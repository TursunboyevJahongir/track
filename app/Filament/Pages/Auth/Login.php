<?php

namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Http\Livewire\Auth\Login as FilamentLogin;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class Login extends FilamentLogin
{
    public $phone = '';
    public $password = '';
    public $remember = false;

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->addError('phone', __('filament::login.messages.throttled', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]));

            return null;
        }

        $data = $this->form->getState();

        if (!Filament::auth()->attempt([
            'phone' => $data['phone'],
            'password' => $data['password'],
        ], $data['remember'])) {
            $this->addError('phone', __('filament::login.messages.failed'));

            return null;
        }

        return app(LoginResponse::class);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('phone')
                ->label(__('auth.phone_number'))
                ->required()->mask(
                    fn (TextInput\Mask $mask) =>
                    $mask
                        ->pattern('+{998}(00)000-00-00')
                        ->lazyPlaceholder(false)
                )
                ->required()
                ->autocomplete(),
            TextInput::make('password')
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->required(),
            Checkbox::make('remember')
                ->label(__('filament::login.fields.remember.label')),
        ];
    }


    public function render(): View
    {
        return view('filament.pages.auth.login')->layout('filament::components.layouts.base', [
            'title' => __('filament::login.title'),
        ]);
    }
}
