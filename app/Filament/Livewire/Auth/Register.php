<?php

namespace App\Filament\Livewire\Auth;

use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions\Modal\Actions\ButtonAction;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Register extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $full_name;
    public $email;
    public $password;
    public $password_confirm;
    public $lang;

    public function mount()
    {
        if (auth()->check()) {
            return redirect(config("filament.home_url"));
        }
    }

    public function messages(): array
    {
        return [
            'email.unique' => __('filament-breezy::default.registration.notification_unique'),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('full_name')
                ->label(__('filament-breezy::default.fields.name'))
                ->required(),
            Forms\Components\TextInput::make('email')
                ->label(__('filament-breezy::default.fields.email'))
                ->required()
                ->email()
                ->unique(table: config('filament-breezy.user_model')),
            Forms\Components\TextInput::make('password')
                ->label(__('filament-breezy::default.fields.password'))
                ->required()
                ->password()
                ->rules([Password::min(8)->letters()->numbers()]),
            Forms\Components\TextInput::make('password_confirm')
                ->label(__('filament-breezy::default.fields.password_confirm'))
                ->required()
                ->password()
                ->same('password'),

            Forms\Components\Select::make('lang')
                ->options([
                    'uz' => __('app.uz'),
                    'ru' => __('app.ru'),
                    'en' => __('app.en'),
                ])
                ->reactive()
                ->afterStateUpdated(function (Closure $set, $state) {
                    app()->setLocale($state);
                    request()->session('locale',$state);
                })
                ->disablePlaceholderSelection()
                ->label(__('app.change_lang')),
        ];
    }

    protected function prepareModelData($data): array
    {
        $preparedData = [
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => '123',
            'password' => $data['password'],
        ];

        return $preparedData;
    }



    public function register()
    {
        $preparedData = $this->prepareModelData($this->form->getState());

        $user = config('filament-breezy.user_model')::create($preparedData);

        event(new Registered($user));
        Auth::login($user, true);

        return redirect()->to(config('filament-breezy.registration_redirect_url'));
    }

    public function render(): View
    {
        $view = view('filament-breezy::register');

        $view->layout('filament::components.layouts.base', [
            'title' => __('filament-breezy::default.registration.title'),
        ]);

        return $view;
    }
}
