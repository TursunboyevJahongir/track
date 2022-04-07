<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SmsConfirmCheck
{
    use SerializesModels, Dispatchable;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public string $phone, public string $code, public string|null $old_phone = null)
    {
    }
}
