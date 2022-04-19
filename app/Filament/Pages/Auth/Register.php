<?php

namespace App\Filament\Pages\Auth;

use App\Events\SmsConfirmSend;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class Register extends Component implements HasForms
{
    use InteractsWithForms;

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
            'phone.unique' => __('This phone number already registered.'),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('full_name')
                ->label(__('auth.full_name'))
                ->required(),
            TextInput::make('phone')
                ->label(__('auth.phone_number'))->required()
                ->unique('users', 'phone')
                ->mask(
                    fn (TextInput\Mask $mask) =>
                    $mask
                        ->pattern('+{998}(00)000-00-00')
                        ->lazyPlaceholder(false)
                ),
            TextInput::make('email')
                ->label(__('Email'))
                ->email()
                ->nullable(),
            TextInput::make('password')
                ->label(__('auth.enter_password'))
                ->required()
                ->password()
                ->rules([Password::min(8)->letters()->numbers()]),
            TextInput::make('password_confirm')
                ->label(__('auth.confirm_password'))
                ->required()
                ->password()
                ->same('password'),
            Hidden::make('author_id')->default(null),
        ];
    }

    public function register()
    {
        $user = User::create($this->form->getState());
        // Filament::auth()->login($user);

        // return redirect(config("filament.home_url"));
        // #todo: send verification sms
        // #todo: review verification process
        SmsConfirmSend::dispatch($user->phone);
        $this->redirect(route('verify-phone', ['account' => base64_encode($user->phone)]));
    }


    public function render(): View
    {
        return view('filament.pages.auth.register')->layout('filament::components.layouts.base', [
            'title' => __('auth.registration_heading'),
        ]);
    }
}
