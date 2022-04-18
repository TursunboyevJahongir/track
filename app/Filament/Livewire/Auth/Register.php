<?php

namespace App\Filament\Livewire\Auth;

use Filament\Forms;
use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\Rules\Password;

class Register extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $full_name;
    public $phone;
    public $email;
    public $password;
    public $password_confirm;
    public $author_id;

    public function mount()
    {
        if (auth()->check()) {
            return redirect(config("filament.home_url"));
        }
    }

    public function messages(): array
    {
        return [
            'phone.unique' => __('filament-breezy::default.registration.notification_unique'),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('full_name')
                ->label(__('auth.full_name'))
                ->required(),
            Forms\Components\TextInput::make('phone')
                ->label(__('auth.phone_number'))->required()
                ->unique(config('filament-breezy.user_model'))
                ->mask(fn(TextInput\Mask $mask) => $mask->pattern('+{998}(00)000-00-00')),
            Forms\Components\TextInput::make('email')->email()->nullable(),
            Forms\Components\TextInput::make('password')
                ->label(__('auth.enter_password'))
                ->required()
                ->password()
                ->rules([Password::min(8)->letters()->numbers()]),
            Forms\Components\TextInput::make('password_confirm')
                ->label(__('auth.confirm_password'))
                ->required()
                ->password()
                ->same('password'),
            Forms\Components\Hidden::make('author_id')->default(null),
        ];
    }

    public function register()
    {
        $user         = User::create($this->form->getState());
        Auth::login($user, true);
        $this->redirect(route('verify'));
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
