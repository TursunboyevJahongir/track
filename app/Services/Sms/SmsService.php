<?php


namespace App\Services\Sms;

use App\Contracts\SmsRepositoryContract;
use App\Contracts\SmsServiceContract;
use App\Jobs\SendSmsJob;
use App\Models\SmsConfirm;

class SmsService implements SmsServiceContract
{
    /**
     * @param SmsRepositoryContract $repository
     */
    public function __construct(protected SmsRepositoryContract $repository)
    {
    }

    /**
     * @param $phone
     * @param null $old_phone
     *
     * @return bool
     * @throws CodeNotExpired
     * @throws PhoneBlockedException
     */
    public function sendConfirm($phone, $old_phone = null): bool
    {
        $smsConfirm = $this->repository->findByPhone($phone);
        if ($smsConfirm === null) {
            $smsConfirm = new SmsConfirm();
        }

        if ($this->repository->isOLd($smsConfirm)) {
            $this->repository->unblockPhone($smsConfirm);
        } else {
            if ($this->repository->isBlockExpired($smsConfirm)) {
                $this->repository->unblockPhone($smsConfirm);
            }

            if ($this->repository->isOutOfResendLimit($smsConfirm)) {
                $this->repository->blockPhone($smsConfirm);
            }

            if ($this->repository->isBlocked($smsConfirm)) {
                $time = diffMinutesOnString($smsConfirm->unblocked_at, now());
                throw new PhoneBlockedException(__('sms.phone_blocked', ['time' => $time]), 400);
            }

            if ($this->repository->canNotResend($smsConfirm)) {
                $time = diffMinutesOnString(now(), $smsConfirm->updated_at->addMinute());
                throw new CodeNotExpired(__('sms.not_expired', ['phone' => $phone, 'time' => $time]), 400);
            }
        }

        $code = config('sms.sms-code');
        $smsConfirm->fill([
                              'code'         => $code,
                              'try_count'    => 0,
                              'resend_count' => $smsConfirm->resend_count + 1,
                              'phone'        => $phone,
                              'old_phone'    => $smsConfirm->old_phone ?? $old_phone,
                              'expired_at'   => now()->addMinutes(config('sms.sms-expiry-minutes'))
                          ]);
        empty($smsConfirm->id) ? $smsConfirm->save() : $smsConfirm->update();

        SendSmsJob::dispatchAfterResponse($smsConfirm);

        return true;
    }

    /**
     * @param string $phone
     * @param string $code
     * @param string|null $old_phone
     *
     * @return bool
     * @throws CodeExpired
     * @throws InvalidConfirmationCodeException
     * @throws TooManyAttemptsException|OperationProhibitedException
     */
    public function confirm(string $phone, string $code, string $old_phone = null): bool
    {
        /**
         * @var SmsConfirm $smsConfirm
         */
        $smsConfirm = $this->repository->findByPhone($phone);

        if ($old_phone !== $smsConfirm->old_phone) {
            throw new OperationProhibitedException(__('sms.operation_prohibited'), 403);
        }

        if ($smsConfirm === null) {
            throw new InvalidConfirmationCodeException(__('sms.invalid_code'), 404);
        }

        if ($this->repository->isOutOfTries($smsConfirm)) {
            throw new TooManyAttemptsException(__('sms.too_many_attempts'), 400);
        }


        if ($this->repository->SmsExpirySeconds($smsConfirm)) {
            throw new CodeExpired(__('sms.code_expired'), 400);
        }

        if ($smsConfirm->code != $code) {
            ++$smsConfirm->try_count;
            $smsConfirm->save();

            throw new InvalidConfirmationCodeException(__('sms.invalid_code'), 404);
        }

        return $this->repository->delete($smsConfirm->phone);
    }
}
