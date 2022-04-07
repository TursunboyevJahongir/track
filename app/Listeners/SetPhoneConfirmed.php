<?php

namespace App\Listeners;


use App\Contracts\UserRepositoryContract;
use App\Events\PhoneConfirmed;

class SetPhoneConfirmed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(protected UserRepositoryContract $repository)
    {
    }

    /**
     * Handle the event.
     *
     * @param PhoneConfirmed $event
     *
     * @return void
     */
    public function handle(PhoneConfirmed $event)
    {
        $this->repository->update($event->user->id, [
            'is_active' => true,
            'phone_confirmed' => true,
            'phone_confirmed_at' => now()]);
    }
}
