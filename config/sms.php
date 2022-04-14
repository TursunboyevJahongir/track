<?php

return [
    'sms-resend-after-seconds' => 60,
    'sms-max-try-count' => 5,
    'sms-max-resend-count' => 3,
    'sms-expiry-minutes' => 2,
    'sms-phone-blocked-minutes' => 15,
    'code-length' => 4,

    'sms-api-url' => env('ETC_SMS_URL'),
    'sms-sender' => env('ETC_SMS_SENDER'),
    'sms-login' => env('ETC_SMS_LOGIN'),
    'sms-password' => env('ETC_SMS_PASSWORD'),

    'sms-code' => env('SMS_CODE', rand(1000, 9999)),
];
