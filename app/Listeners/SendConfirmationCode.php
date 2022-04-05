<?php

namespace App\Listeners;

use App\Events\SmsConfirmSend;
use Exception;

class SendConfirmationCode
{

    /**
     * @param SmsServiceContract $repository
     */
    public function __construct(protected SmsServiceContract $repository) { }

    /**
     * User Registered event handler
     *
     * @param SmsConfirmSend $event
     *
     * @throws Exception
     */
    public function handle(SmsConfirmSend $event)
    {
        $this->repository->sendConfirm($event->phone,$event->old_phone);
    }
}
