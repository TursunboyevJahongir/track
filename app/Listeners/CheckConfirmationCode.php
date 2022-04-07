<?php

namespace App\Listeners;

use App\Contracts\SmsServiceContract;
use App\Events\SmsConfirmCheck;

class CheckConfirmationCode
{

    /**
     * @param SmsServiceContract $repository
     */
    public function __construct(protected SmsServiceContract $repository) { }

    /**
     * User Registered event handler
     *
     * @param SmsConfirmCheck $event
     *
     */
    public function handle(SmsConfirmCheck $event)
    {
        $this->repository->confirm($event->phone, $event->code, $event->old_phone);
    }
}
