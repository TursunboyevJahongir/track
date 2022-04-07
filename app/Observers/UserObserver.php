<?php

namespace App\Observers;

use App\Events\SmsConfirmSend;
use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        SmsConfirmSend::dispatch($user->phone);
    }

    public function created(User $user)
    {
        //
    }

    public function updated(User $user)
    {
        //
    }

    public function deleted(User $user)
    {
        //
    }

    public function restored(User $user)
    {
        //
    }

    public function forceDeleted(User $user)
    {
        //
    }
}
