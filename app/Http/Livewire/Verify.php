<?php

namespace App\Http\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Verify extends Component implements HasForms
{
    use InteractsWithForms;

    public function __construct() {

        parent::__construct();
    }

    public $code;
    public $phone;
    public $seconds;

    public function mount(){
        parent::mount();
        $this->phone = auth()->user()->phone;

    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('code')->numeric()->autofocus()->label(__('sms.enter_the_code'))
        ];
    }

    public function render()
    {
        return view('livewire.verify')
            ->layout("filament::components.layouts.base", [
                "title" => __('sms.verify_header'),
            ]);
    }
}
