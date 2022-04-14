<?php

namespace App\Http\Livewire;

use App\Events\SmsConfirmSend;
use App\Models\SmsConfirm;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Verify extends Component implements HasForms
{
    use InteractsWithForms;

    public $code;
    public $phone;
    public $seconds;
    public $sendAgain = false;
    public $tryCount = 0;
    public $expiredAt;
    public $unblockedAt = null;
    public $resendTime;
    public $smsExpirySeconds;
    public $blockedMinutes = 15;

    public function mount(){
        parent::mount();
        $sms = SmsConfirm::phone(auth()->user()->phone)->first();
        if (!$sms) {
            try {
                event(new SmsConfirmSend(auth()->user()->phone));
                $sms = SmsConfirm::phone(auth()->user()->phone)->first();
            } catch (\Exception $e) {
                Filament::notify('error', __('sms.too_many_attempts'));
            }
        }
        $this->resendTime = strtotime($sms->updated_at->addSeconds(config('sms.sms-resend-after-seconds'))) - time();
        $this->tryCount = config('sms.sms-max-try-count') - $sms->try_count;
        $this->smsExpirySeconds = strtotime($sms->expired_at) - time();
        $this->phone = auth()->user()->phone;

        if ($this->resendTime <= 0) {
            $this->sendAgain = true;
            $this->resendTime = 0;
        }

    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('code')->numeric()->autofocus()
                ->mask(fn(TextInput\Mask $mask) => $mask->pattern('0-0-0-0'))->placeholder('0-0-0-0')
                ->label(__('sms.enter_the_code')),
        ];
    }

    public function submit(){
        $this->validate(['code' => 'required|digits:'.config('sms.code-length')]);
        if ($this->smsExpirySeconds < 0) {
            Filament::notify('error',__('sms.code_expired'));
            return false;
        }
        if ($this->tryCount <= 0) {
            Filament::notify('error',__('sms.too_many_attempts'));
            return false;
        }
        $user = auth()->user();
        $sms = SmsConfirm::phone($user->phone)->first();
        $sms->try_count++;

        if ($sms->code == $this->code){
            $user->is_active = 1;
            $user->phone_confirmed = 1;
            $user->phone_confirmed_at = Carbon::now();
            $sms->unblocked_at = Carbon::now();
            $user->save();
            Filament::notify('success',__('messages.success'));
            $this->redirect('/');
            return true;
        }
        Filament::notify('error',__('sms.invalid_code'));
        $sms->save();
        return true;
    }

    public function resendSms(){
        try {
            event(new SmsConfirmSend(auth()->user()->phone));
        } catch (\Exception $e) {
            Filament::notify('error',__('sms.confirmation_sent'));
            return false;
        }
        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.verify')
            ->layout("filament::components.layouts.base", [
                "title" => __('sms.verify_header'),
            ]);
    }
}
