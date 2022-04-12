<?php

namespace App\Http\Livewire;

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
                ->options([
                    'uz' => __('app.uz'),
                    'ru' => __('app.ru'),
                    'en' => __('app.en'),
                ])->disablePlaceholderSelection()
                ->label(false)
                ->reactive(),
        ];
    }

    public function render()
    {
        return view('livewire.select-lang');
    }

    public function updatedLang($value){
        app()->setLocale($value);
        request()->session()->put('locale', $value);
        Filament::notify('success',__('messages.success'),true);
        return $this->redirect(url()->previous());
    }
}
