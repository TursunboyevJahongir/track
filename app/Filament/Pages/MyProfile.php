<?php

namespace App\Filament\Pages;

use App\Events\UpdateImage;
use App\Models\User;
use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rules\Password;

class MyProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.my-profile';

    public $user;
    public $new_password;
    public $new_password_confirmation;
    public $token_name;
    public $abilities = [];
    public $plain_text_token;
    public $hasTeams;
    public $avatar;

    public function mount()
    {
        $this->user = auth()->user()->loadMissing('avatar');
        $this->updateProfileForm->fill($this->user->toArray());
        $this->updateProfileForm->fill(['avatar' => $this->user->avatar->path_1024]);
    }

    protected function getForms(): array
    {
        return array_merge(parent::getForms(), [
            "updateProfileForm" => $this->makeForm()
                ->schema($this->getUpdateProfileFormSchema())
                ->model($this->user),
            "updatePasswordForm" => $this->makeForm()->schema(
                $this->getUpdatePasswordFormSchema()
            ),
            "createApiTokenForm" => $this->makeForm()->schema(
                $this->getCreateApiTokenFormSchema()
            ),
        ]);
    }

    protected function getUpdateProfileFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make("full_name")
                ->label(__('auth.full_name')),
            Forms\Components\TextInput::make("email")
                ->unique(ignorable: $this->user)
                ->label(__('filament-breezy::default.fields.email'))
                ->disabled($this->user->google_id || $this->user->facebook_id),
            Forms\Components\TextInput::make("phone")
                ->label(__('auth.phone_number')),
        ];
    }


    public function updateProfile()
    {
        $this->user->update($this->updateProfileForm->getState());
        $this->notify("success", __('filament-breezy::default.profile.personal_info.notify'));
    }

    public function updatedAvatar(){
        UpdateImage::dispatch($this->avatar, $this->user->avatar(), User::RESOURCES_IDENTIFIER, User::PATH);
        $this->redirect(url()->previous());
    }

    protected function getUpdatePasswordFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make("new_password")
                ->label(__('auth.enter_password'))
                ->password()
                ->rules(config('filament-breezy.password_rules'))
                ->rules([Password::min(8)->letters()->numbers()])
                ->required(),
            Forms\Components\TextInput::make("new_password_confirmation")
                ->label(__('auth.confirm_password'))
                ->password()
                ->same("new_password")
                ->required(),
        ];
    }

    public function updatePassword()
    {
        $state['password'] = $this->updatePasswordForm->getState()['new_password'];
        $this->user->update($state);
        session()->forget("password_hash_web");
        $this->notify("success", __('filament-breezy::default.profile.password.notify'));
        $this->reset(["new_password", "new_password_confirmation"]);
    }

    protected function getCreateApiTokenFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('token_name')->label(__('filament-breezy::default.fields.token_name'))->required(),
            Forms\Components\CheckboxList::make('abilities')
                ->label(__('filament-breezy::default.fields.abilities'))
                ->options(config('filament-breezy.sanctum_permissions'))
                ->columns(2)
                ->required(),
        ];
    }

    public function createApiToken()
    {
        $state = $this->createApiTokenForm->getState();
        $indexes = $state['abilities'];
        $abilities = config("filament-breezy.sanctum_permissions");
        $selected = collect($abilities)->filter(function ($item, $key) use (
            $indexes
        ) {
            return in_array($key, $indexes);
        })->toArray();
        $this->plain_text_token = auth()->user()->createToken($state['token_name'], array_values($selected))->plainTextToken;
        $this->notify("success", __('filament-breezy::default.profile.sanctum.create.notify'));
        $this->emit('tokenCreated');
        $this->reset(['token_name']);
    }

    protected function getBreadcrumbs(): array
    {
        return [
            url()->current() => __('filament-breezy::default.profile.profile'),
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('filament-breezy::default.profile.account');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-breezy::default.profile.profile');
    }

    protected function getTitle(): string
    {
        return __('filament-breezy::default.profile.my_profile');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return config('filament-breezy.show_profile_page_in_navbar');
    }

    public function render(): View
    {
        return \view('filament.pages.my-profile')
            ->layout('filament::components.layouts.app',[
                'title' => self::$title,
                'breadcrumbs' => $this->getBreadcrumbs()
            ]);
    }
}
