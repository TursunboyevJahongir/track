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
                ->label(__('filament-breezy::default.fields.name'))
                ->required(),
            Forms\Components\TextInput::make('phone')
                ->label(__('auth.phone_number'))->required()
                ->unique(config('filament-breezy.user_model'))
                ->mask(fn(TextInput\Mask $mask) => $mask->pattern('+{998}(00)000-00-00')),
            Forms\Components\TextInput::make('password')
                ->label(__('filament-breezy::default.fields.password'))
                ->required()->password()
                ->rules([Password::min(8)->letters()->numbers()]),
            Forms\Components\TextInput::make('password_confirm')
                ->label(__('filament-breezy::default.fields.password_confirm'))
                ->required()->password()
                ->same('password'),
            Forms\Components\Hidden::make('author_id')->default(null),
        ];
    }

    protected function prepareModelData($data): array
    {
        $preparedData = [
            'full_name' => $data['full_name'],
            'phone'     => $data['phone'],
            'password'  => $data['password'],
            'author_id' => $data['author_id'],
        ];

        return $preparedData;
    }


    public function register()
    {
        $preparedData = $this->prepareModelData($this->form->getState());
        $user         = User::create($preparedData);
        Auth::login($user, true);
        redirect(route('verify'));
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
