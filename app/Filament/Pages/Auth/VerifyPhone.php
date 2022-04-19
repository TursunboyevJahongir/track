<?php

namespace App\Filament\Pages\Auth;

use App\Events\PhoneConfirmed;
use App\Events\SmsConfirmCheck;
use App\Events\SmsConfirmSend;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class VerifyPhone extends Component implements HasForms
{
    use InteractsWithForms;

    public $phone = '';
    public $code = '';

    protected $user = null;

    public function mount()
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }
        $this->phone = base64_decode(request()->get('account'));

        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('code')->numeric()->autofocus()
                ->mask(fn (TextInput\Mask $mask) => $mask->pattern('0-0-0-0')->lazyPlaceholder(false))->placeholder('0-0-0-0')
                ->rule('required|digits:' . config('sms.code-length'))
                ->label(__('sms.enter_the_code'))
        ];
    }

    public function verify()
    {
        try {
            event(new SmsConfirmCheck($this->phone, $this->code));
        } catch (\Exception $e) {
            Filament::notify('error', $e->getMessage());
            return false;
        }
        $user = User::query()->firstWhere('phone', $this->phone);
        PhoneConfirmed::dispatch($user);
        Filament::auth()->login($user);
        return redirect(config('filament.home_url'));
    }

    public function resend()
    {
        try {
            event(new SmsConfirmSend($this->phone));
            Filament::notify('success', __('sms.sms_sent'), true);
        } catch (\Exception $e) {
            Filament::notify('error', $e->getMessage(), true);
        }
        return $this->redirect(url()->previous());
    }

    public function render(): View
    {
        return view('filament.pages.auth.verify-phone')
            ->layout('filament::components.layouts.base', [
                'title' => __('auth.verification_title'),
            ]);
    }
}
