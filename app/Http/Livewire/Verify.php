<?php

namespace App\Http\Livewire;

use App\Events\SmsConfirmSend;
use App\Models\SmsConfirm;
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
        //event(new SmsConfirmSend(auth()->user()->phone));
        $sms = SmsConfirm::phone(auth()->user()->phone)->first();
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
