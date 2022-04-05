<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SmsConfirmSend
{
    use SerializesModels, Dispatchable;

    /**
     * User register event
     *
     * @return void
     */
    public function __construct(public string $phone, public string|null $old_phone = null)
    {
    }
}
