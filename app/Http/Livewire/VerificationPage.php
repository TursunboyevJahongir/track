<?php

namespace App\Http\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class VerificationPage extends Component implements HasForms
{
    use InteractsWithForms;

    public $code;

    public function mount()
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('code')->numeric()
        ];
    }

    public function render()
    {
        return view('livewire.verification-page');
    }
}
