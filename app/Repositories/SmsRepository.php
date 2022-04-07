<?php

namespace App\Repositories;

use App\Contracts\SmsRepositoryContract;
use App\Core\Models\CoreModel;
use App\Models\SmsConfirm;

class SmsRepository implements SmsRepositoryContract
{
    public function __construct(protected SmsConfirm $model)
    {
    }

    /**
     * @param $phone
     *
     * @return CoreModel|null
     */
    public function findByPhone($phone): CoreModel|null
    {
        return SmsConfirm::phone($phone)->first();
    }

    /**
     * @param CoreModel $model
     *
     * @return bool
     */
    public function isOLd(CoreModel $model)
    {
        return $model->updated_at?->addMinutes(config('sms.sms-phone-blocked-minutes'))
            ->lessThanOrEqualTo(now());
    }

    public function canNotResend(CoreModel $model)
    {
        return $model->updated_at?->addSeconds(config('sms.sms-resend-after-seconds'))
            ->greaterThan(now());
    }

    /**
     * @param CoreModel $model
     *
     * @return bool
     */
    public function isBlocked(CoreModel $model): bool
    {
        return $model->unblocked_at !== null && $model->unblocked_at->greaterThan(now());
    }

    /**
     * @param CoreModel $model
     *
     * @return bool
     */
    public function isBlockExpired(CoreModel $model): bool
    {
        return $model->unblocked_at !== null && $model->unblocked_at->lessThan(now());
    }

    public function blockPhone(CoreModel $model)
    {
        $model->unblocked_at = now()->addMinutes(config('sms.sms-phone-blocked-minutes'));
        $model->save();
    }

    public function unblockPhone(CoreModel $model)
    {
        $model->try_count = 0;
        $model->resend_count = 0;
        $model->unblocked_at = null;
        $model->save();
    }

    /**
     * @param CoreModel $model
     *
     * @return bool
     */
    public function isOutOfTries(CoreModel $model): bool
    {
        return $model->unblocked_at === null && $model->try_count > config('sms.sms-max-try-count');
    }

    /**
     * @param CoreModel $model
     *
     * @return bool
     */
    public function isOutOfResendLimit(CoreModel $model): bool
    {
        return $model->unblocked_at === null && $model->resend_count > config('sms.sms-max-resend-count');
    }

    /**
     * @param CoreModel $model
     *
     * @return bool
     */
    public function SmsExpirySeconds(CoreModel $model): bool
    {
        return $model->unblocked_at === null && $model->expired_at->lessThan(now());
    }

    /**
     * @param string $phone
     *
     * @return bool
     */
    public function isPhoneBlocked(string $phone): bool
    {
        $sms = SmsConfirm::phone($phone)->first();

        return $sms !== null && $sms->unblocked_at !== null && $sms->unblocked_at->greaterThan(now());
    }

    /**
     * @param string $phone
     *
     * @return bool
     */
    public function delete(string $phone)
    {
        return $this->findByPhone($phone)?->delete();
    }

}
