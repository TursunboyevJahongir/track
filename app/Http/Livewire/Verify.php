<?php

namespace App\Http\Livewire;

use App\Contracts\SmsRepositoryContract;
use App\Events\PhoneConfirmed;
use App\Events\SmsConfirmCheck;
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

    public $sms;
    public $code;
    public $phone;
    public $seconds;
    public $sendAgain   = false;
    public $tryCount    = 0;
    public $expiredAt;
    public $unblockedAt = null;
    public $resendTime;
    public $smsExpirySeconds;
    public $blockedMinutes;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->auth = auth()->user();
        $this->sms  = SmsConfirm::phone(auth()->user()->phone)->first();
    }


    public function mount()
    {
        // if ($this->auth->is_active && $this->auth->phone_confirmed){
        //     Filament::notify('error',__('sms.operation_prohibited'),true);
        //     $this->redirect(config('filament.home_url'));
        // }
        parent::mount();
        if (!$this->sms) {
            $this->sms = event(new SmsConfirmSend($this->auth->phone))[0];
        } elseif ($this->sms->expired_at->lessThan(now())) {
            try {
                $this->sms = event(new SmsConfirmSend($this->auth->phone))[0];
            } catch (\Exception $e) {
                Filament::notify('error', $e->getMessage());
            }
        }
        $this->blockedMinutes   = $this->sms->unblocked_at ? strtotime($this->sms->unblocked_at) - time() : null;
        $this->resendTime       = $this->blockedMinutes ?? strtotime($this->sms->updated_at?->addSeconds(config('sms.sms-resend-after-seconds')))
            - time();

        $this->tryCount         = config('sms.sms-max-try-count') - $this->sms
                ->try_count;
        $this->smsExpirySeconds = strtotime($this->sms
                                                ->expired_at) - time();
        $this->phone            = $this->auth->phone;

        if ($this->resendTime <= 0) {
            $this->sendAgain  = true;
            $this->resendTime = 0;
        }
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('code')->numeric()->autofocus()
                ->mask(fn(TextInput\Mask $mask) => $mask->pattern('0-0-0-0'))->placeholder('0-0-0-0')
                ->label(__('sms.enter_the_code'))
                ->disabled(strtotime($this->sms->unblocked_at) - time() > 0),
        ];
    }

    public function submit()
    {
        $this->validate(['code' => 'required|digits:' . config('sms.code-length')]);
        try {
            event(new SmsConfirmCheck($this->phone, $this->code));
        } catch (\Exception $e) {
            Filament::notify('error', $e->getMessage());
            return false;
        }
        PhoneConfirmed::dispatch($this->auth);
        return redirect(config('filament.home_url'));
    }

    public function resendSms()
    {
        try {
            event(new SmsConfirmSend($this->auth->phone));
        } catch (\Exception $e) {
            Filament::notify('error', $e->getMessage(), true);
        }

        $this->redirect(url()->previous());
    }

    public function render()
    {
        return view('livewire.verify')
            ->layout("filament::components.layouts.base", [
                "title" => __('sms.verify_header'),
            ]);
    }
}
