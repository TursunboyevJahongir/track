<?php

namespace App\Filament\Livewire\Auth;

use Filament\Forms;
use Filament\Http\Livewire\Concerns\CanNotify;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Verify extends Component implements Forms\Contracts\HasForms
{
    use CanNotify;
    use Forms\Concerns\InteractsWithForms;

    public bool $hasBeenSent = false;

    public function mount()
    {
        if (auth()->check() && auth()->user()?->hasVerifiedEmail()) {
            return redirect(config("filament.home_url"));
        } elseif (! auth()->check()) {
            // User is not logged in...
            return redirect(route('filament.auth.login'));
        }
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route("filament.auth.login");
    }

    public function resend()
    {
        auth()
            ->user()
            ->sendEmailVerificationNotification();

        $this->notify(
            "success",
            __("filament-breezy::default.verification.notification_resend")
        );
        $this->hasBeenSent = true;
    }

    public function render(): View
    {
        $view = view("filament-breezy::verify");

        $view->layout("filament::components.layouts.base", [
            "title" => __("filament-breezy::default.verification.title"),
        ]);

        return $view;
    }
}
