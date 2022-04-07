<?php

namespace App\Contracts;

interface SmsServiceContract
{
    public function sendConfirm(string $phone, string $old_phone = null): bool;

    public function confirm(string $phone, string $code, string $old_phone = null): bool;
}
