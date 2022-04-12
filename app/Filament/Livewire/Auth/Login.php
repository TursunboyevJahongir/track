<?php

namespace App\Filament\Livewire\Auth;

use Closure;
use Filament\Forms\ComponentContainer;
use Filament\Http\Livewire\Auth\Login as FilamentLogin;
use Filament\Http\Livewire\Concerns\CanNotify;
use Illuminate\Contracts\View\View;
use Filament\Forms;

class Login extends FilamentLogin
{
    use CanNotify;


    public function mount(): void
    {
        parent::mount();
        if ($email = request()->query("email", "")) {
            $this->form->fill(["email" => $email]);
        }
        if (request()->query("reset")) {
            $this->notify("success", __("passwords.reset"), true);
        }
    }


    protected function getFormSchema(): array
    {
        $fields = parent::getFormSchema();
        array_push($fields,
            Forms\Components\Select::make('lang')
                ->options([
                    'uz' => __('app.uz'),
                    'ru' => __('app.ru'),
                    'en' => __('app.en'),
                ])
                ->reactive()
                ->afterStateUpdated(function (Closure $set, $state) {
                    app()->setLocale($state);
                    request()->session()->put('locale',$state);
                })
                ->disablePlaceholderSelection()
                ->label(__('app.change_lang'))
        ); // TODO: Change the autogenerated stub
        return $fields;
    }


    public function render(): View
    {
        $view = view("filament-breezy::login");

        /*
         * Livewire uses a macro for the `layout()` method.
         *
         * @phpstan-ignore-next-line
         */
        $view->layout("filament::components.layouts.base", [
            "title" => __("filament::login.title"),
        ]);

        return $view;
    }
}
