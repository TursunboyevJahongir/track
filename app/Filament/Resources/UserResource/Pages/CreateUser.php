<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Events\UpdateImage;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\View\View;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public $avatar;

    public function create(bool $another = false): void
    {
        $user = User::create($this->form->getState());
        UpdateImage::dispatch($this->avatar, $user->avatar(), User::RESOURCES_IDENTIFIER, User::PATH);
        Filament::notify('success',__('messages.success'));
        $this->redirect('/users');
    }



    public function render(): View
    {
        return \view('filament.resources.user-resource.pages.create')
            ->layout('filament::components.layouts.app', [
                'title' => self::$title,
                'breadcrumbs' => self::$breadcrumb
            ]);
    }
}
