<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Enums\AvailableLocalesEnum;
use App\Filament\Resources\RoleResource;
use App\Http\Livewire\Translatable;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    use Translatable;

    protected function getForms(): array
    {
        return array_merge(parent::getForms(), [
            "translatableForm" => $this->makeForm()
                ->schema($this->getTranslatableFormSchema())
        ]);
    }

    public function save(bool $shouldRedirect = true): void
    {
        $this->callHook('beforeValidate');

        $data = $this->form->getState();

        $this->callHook('afterValidate');

        $data = $this->mutateFormDataBeforeSave($data);

        $this->callHook('beforeSave');
        dd($data);
        $this->handleRecordUpdate($this->record, $data);

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

    public function render(): View
    {
        return \view('filament.resources.roles.pages.edit')
            ->layout('filament::components.layouts.app',[
                'title' => self::$title,
                'breadcrumbs' => self::$breadcrumb
            ]);
    }
}
