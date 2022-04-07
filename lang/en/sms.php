<?php

return [
        'phone_blocked'        => 'Your phone number is blocked. Please retry in :time',
        'confirmation_sent'    => 'Confirmation code is sent via sms to :attribute. Code is valid within ' .
                config('sms.sms-expiry-minutes') . ' minutes',
        'invalid_code'         => 'Confirmation code is not valid',
        'operation_prohibited' => 'Operation is prohibited',
        'too_many_attempts'    => 'Too many tries. Please, use resend SMS later',
        'code_expired'         => 'Confirmation code has expired. Please, use resend SMS after ',
        'minutes_diff'         => ':minutes min :seconds sec',
        'not_expired'          => 'SMS code is sent to :phone. You can use resend after :time',
];
