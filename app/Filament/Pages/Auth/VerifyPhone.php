<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class VerifyPhone extends Component implements HasForms
{
    use InteractsWithForms;

    public function render(): View
    {
        return view('filament::pages.auth.verify-phone')
            ->layout('filament::components.layouts.base', [
                'title' => __('auth.verification_title'),
            ]);
    }
}
