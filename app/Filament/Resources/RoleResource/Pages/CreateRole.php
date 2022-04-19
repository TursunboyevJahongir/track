<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;
    protected function form(Form $form): Form
    {

        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('guard_name')->required()->maxLength(255),
            TextInput::make('title_uz')->required(config('app.main_locale') == 'uz')->maxLength(255),
            TextInput::make('title_ru')->required(config('app.main_locale') == 'ru')->maxLength(255),
            TextInput::make('title_en')->required(config('app.main_locale') == 'en')->maxLength(255),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['title'] = [
            'uz' => $this->form->getState()['title_uz'],
            'ru' => $this->form->getState()['title_ru'],
            'en' => $this->form->getState()['title_en'],
        ];
        return $data;
    }
}
