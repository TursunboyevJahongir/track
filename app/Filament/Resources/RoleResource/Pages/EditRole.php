<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Permission;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    public function mount($record): void
    {
      parent::mount($record);
        $this->form->fill(array_merge(
            $this->record->getAttributes(),
            [
                'title_uz' => $this->record->title_array->uz,
                'title_ru' => $this->record->title_array->ru,
                'title_en' => $this->record->title_array->en
            ])
        );

    }


    protected function form(Form $form): Form
    {

        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('guard_name')->required()->maxLength(255)->disabled(true),
            TextInput::make('title_uz')->required(config('app.main_locale') == 'uz')->maxLength(255),
            TextInput::make('title_ru')->required(config('app.main_locale') == 'ru')->maxLength(255),
            TextInput::make('title_en')->required(config('app.main_locale') == 'en')->maxLength(255),
        ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {

        $data['title'] = [
            'uz' => $this->form->getState()['title_uz'],
            'ru' => $this->form->getState()['title_ru'],
            'en' => $this->form->getState()['title_en'],
        ];
        return $data;
    }


    public function render(): View
    {
        return \view('filament.resources.roles.pages.edit')
            ->layout('filament::components.layouts.app',[
                'title' => self::$title,
                'breadcrumbs' => self::$breadcrumb
            ]);
    }
}
