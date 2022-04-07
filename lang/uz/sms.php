<?php

return [
        'phone_blocked'        => "Sizning telefon raqamingiz bloklandi. Iltimos :time dan keyin yana bir bor urinib ko'ring",
        'confirmation_sent'    => "SMS orqali tasdiqlash kodi :attribute ga jo'natildi. Kod ko'rsatilgan vaqt ichida kuchga ega " .
                config('sms.sms-expiry-minutes') . ' daqiqa',
        'invalid_code'         => "Tasdiqlash kodi noto'g'ri",
        'operation_prohibited' => 'Operatsiya taqiqlangan',
        'too_many_attempts'    => "Juda ham ko'p urinish. Iltimos keyinroq qayta SMS jo'natishni ishlatib ko'ring",
        'code_expired'         => "Tasdiqlash kodi eskirdi. Iltimos qayta SMS jo'natishni ko'rsatilgan vaqtdan keyin ishlating",
        'minutes_diff'         => ':minutes daq :seconds son',
        'not_expired'          => "SMS kodi :phone ga jo'natildi. Siz qayta jo'natishni :time dan keyin ishlatishingiz mumkin",
];
