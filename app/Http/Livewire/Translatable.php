<?php

namespace App\Http\Livewire;

use App\Enums\AvailableLocalesEnum;
use Filament\Forms\Components\Select;

trait Translatable
{
    public $language;
    public $translatable;

    public function getTranslatableFormSchema(): array{
        return [
            Select::make('language')
                ->options(AvailableLocalesEnum::toArray())->disablePlaceholderSelection()
                ->label(false)->reactive()
        ];
    }

    public function updatedLanguage(){
        app()->setLocale($this->language);
        parent::fillForm();
    }
}
