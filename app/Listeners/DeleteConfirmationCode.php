<?php

namespace App\Listeners;


use App\Contracts\SmsRepositoryContract;
use App\Events\DeleteConfirmSms;

class DeleteConfirmationCode
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
            protected SmsRepositoryContract $confirm
    ) {
    }

    /**
     * Handle the event.
     *
     * @param DeleteConfirmSms $event
     *
     */
    public function handle(DeleteConfirmSms $event)
    {
        $this->confirm->delete($event->phone);
    }
}
