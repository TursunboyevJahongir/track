<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Events\UpdateImage;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rules\Password;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    public $avatar;

    public function save(bool $shouldRedirect = true): void
    {
        $this->callHook('beforeValidate');

        $data = $this->form->getState();

        $this->callHook('afterValidate');

        $data = $this->mutateFormDataBeforeSave($data);

        $this->callHook('beforeSave');

        $this->handleRecordUpdate($this->record, $data);
        if ($this->avatar){
            UpdateImage::dispatch($this->avatar, $this->record->avatar(), User::RESOURCES_IDENTIFIER, User::PATH);
        }

        $this->callHook('afterSave');

        $shouldRedirect = $shouldRedirect && ($redirectUrl = $this->getRedirectUrl());

        if (filled($this->getSavedNotificationMessage())) {
            $this->notify(
                'success',
                $this->getSavedNotificationMessage(),
                isAfterRedirect: $shouldRedirect,
            );
        }

        if ($shouldRedirect) {
            $this->redirect($redirectUrl);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('author_id')->hidden()->default(auth()->id()),
                TextInput::make('full_name')->label(__('auth.full_name'))
                    ->required()->maxLength(255),
                TextInput::make('phone')->tel()
                    ->mask(fn(Mask $mask) => $mask->pattern('+{998}(00)000-00-00'))
                    ->maxLength(18)->label(__('auth.phone_number'))->required(),
                TextInput::make('password')->label(__('auth.enter_password'))
                    ->password()->rules([Password::min(8)->letters()->numbers()]),
                TextInput::make('password_confirm')->label(__('auth.confirm_password'))->password()->same('password'),
                TextInput::make('email')->email()
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('phone_confirmed')
                    ->required(),
            ]);
    }

    public function render(): View
    {
        return \view('filament.resources.user-resource.pages.edit')->layout('filament::components.layouts.app',[
            'title' => self::$title,
            'breadcrumbs' => self::$breadcrumb
        ]);
    }
}
