<?php

namespace App\Filament\Pages;

use App\Events\UpdateImage;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Illuminate\Validation\Rules\Password;
use Livewire\WithFileUploads;

class MyProfile extends Page
{
    use WithFileUploads;
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
    public $avatar_file;

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
            TextInput::make("full_name")
                ->label(__('auth.full_name')),
            TextInput::make("email")
                ->unique(ignorable: $this->user)
                ->label(__('Email'))
                ->disabled($this->user->google_id || $this->user->facebook_id),
            TextInput::make("phone")
                ->mask(
                    fn (TextInput\Mask $mask) =>
                    $mask
                        ->pattern('+{998}(00)000-00-00')
                        ->lazyPlaceholder(false)
                )
                ->label(__('auth.phone_number')),
        ];
    }


    public function updateProfile()
    {
        $this->user->update($this->updateProfileForm->getState());
        $this->notify("success", __('Successfully updated'));
    }

    public function updatedAvatar()
    {
        UpdateImage::dispatch($this->avatar, $this->user->avatar(), User::RESOURCES_IDENTIFIER, User::PATH);
        $this->redirect(url()->previous());
    }

    protected function getUpdatePasswordFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make("new_password")
                ->label(__('auth.enter_password'))
                ->password()
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
        $this->notify("success", __('Successfully updated'));
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
        $this->notify("success", __('Successfully created token'));
        $this->emit('tokenCreated');
        $this->reset(['token_name']);
    }

    protected function getBreadcrumbs(): array
    {
        return [
            url()->current() => __('Profile'),
        ];
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Account');
    }

    public static function getNavigationLabel(): string
    {
        return __('Profile');
    }

    protected function getTitle(): string
    {
        return __('My Profile');
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
