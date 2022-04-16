<?php

namespace App\Http\Livewire;

use App\Enums\AvailableLocalesEnum;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms;

class SelectLang extends Component implements HasForms
{
    use InteractsWithForms;

    public $lang;

    public function mount(): void
    {
        parent::mount();
        $this->form->fill(["lang" => config('app.locale')]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('lang')
                ->options(AvailableLocalesEnum::toArray())->disablePlaceholderSelection()
                ->label(false)->reactive()
        ];
    }

    public function updatedLang($value)
    {
        app()->setLocale($value);
        request()->session()->put('locale', $value);
        Filament::notify('success', __('messages.success'), true);
        $this->redirect(url()->previous());
    }


    public function render()
    {
        return view('livewire.select-lang');
    }



}
