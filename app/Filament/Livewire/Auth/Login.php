<?php

namespace App\Filament\Livewire\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Http\Livewire\Auth\Login as FilamentLogin;
use Filament\Http\Livewire\Concerns\CanNotify;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Contracts\View\View;

class Login extends FilamentLogin
{
    use CanNotify;

    public $phone = '';
    public $password = '';
    public $remember = false;
    public function mount(): void
    {
        parent::mount();
        if ($phone = request()->query("phone", "")) {
            $this->form->fill(["phone" => $phone]);
        }
        if (request()->query("reset")) {
            $this->notify("success", __("passwords.reset"), true);
        }
    }
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('phone')
                ->label(__('auth.phone_number'))
                ->required()->mask(fn(TextInput\Mask $mask) => $mask->pattern('+{998}(00)000-00-00'))
                ->autocomplete(),
            TextInput::make('password')
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->required(),
            Checkbox::make('remember')
                ->label(__('filament::login.fields.remember.label')),
        ];
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

        if (! Filament::auth()->attempt([
                                            'phone' => $data['phone'],
                                            'password' => $data['password'],
                                        ], $data['remember'])) {
            $this->addError('phone', __('filament::login.messages.failed'));

            return null;
        }

        return app(LoginResponse::class);
    }

    public function render(): View
    {
        $view = view("filament-breezy::login");

        /*
         * Livewire uses a macro for the `layout()` method.
         *
         * @phpstan-ignore-next-line
         */
        $view->layout("filament::components.layouts.base", [
            "title" => __("filament::login.title"),
        ]);

        return $view;
    }
}
