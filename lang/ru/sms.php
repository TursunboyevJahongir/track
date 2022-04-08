<?php

return [
        'phone_blocked'        => 'Ваш номер телефона заблокирован. Пожалуйста,повторите попытку через :time',
        'confirmation_sent'    => 'Подтверждение по смс отправлено на :attribute. Код действителен до ' .
                config('sms.sms-expiry-minutes') . ' минута',
        'invalid_code'         => 'Код подтверждения недействителен.',
        'operation_prohibited' => 'Операция запрещена.',
        'too_many_attempts'    => 'Слишком много попыток. Пожалуйста, используйте повторную отправку SMS',
        'code_expired'         => 'Действие кода истекло . Пожалуйста, используйте повторную отправку SMS',
        'minutes_diff'         => ':minutes мин :seconds сек',
        'not_expired'          => 'SMS-код отправлен на :phone.Вы можете использовать повторную отправку через :time',
];