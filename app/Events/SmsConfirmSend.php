<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SmsConfirmSend
{
    use SerializesModels, Dispatchable;

    public function __construct(public string $phone, public string|null $old_phone = null)
    {
    }
}
