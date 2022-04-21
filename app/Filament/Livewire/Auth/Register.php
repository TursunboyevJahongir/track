<?php

namespace App\Filament\Livewire\Auth;

use App\Models\Role;
use Filament\Forms;
use App\Models\User;
use Filament\Forms\Components\Hidden;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\Rules\Password;

class Register extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $full_name, $phone, $email, $password,
        $password_confirm, $author_id, $role;

    public function mount()
    {
        if (auth()->check()) {
            return redirect(config("filament.home_url"));
        }
    }

    public function messages(): array
    {
        return [
            'phone.unique' => __('auth.phone_is_already_using'),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('full_name')->label(__('auth.full_name'))->required(),
            TextInput::make('phone')->label(__('auth.phone_number'))->required()
                ->unique(config('filament-breezy.user_model'))
                ->mask(fn(TextInput\Mask $mask) => $mask->pattern('+{998}(00)000-00-00')),
            TextInput::make('email')->email()->nullable(),
            TextInput::make('password')->label(__('auth.enter_password'))->required()->password()
                ->rules([Password::min(8)->letters()->numbers()]),
            TextInput::make('password_confirm')->label(__('auth.confirm_password'))->required()->password()
                ->same('password'),
            Hidden::make('author_id')->default(null),
            Forms\Components\Select::make('role')->label(__('auth.select_role'))
                ->options(Role::all()->pluck('title','id'))->required()
        ];
    }

    public function register()
    {
        $user         = User::create($this->form->getState());
        $user->syncRoles($this->role);
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
