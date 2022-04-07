<?php

namespace App\Contracts;



use App\Core\Models\CoreModel;

interface SmsRepositoryContract
{
    public function findByPhone($phone): CoreModel|null;

    public function isOLd(CoreModel $model);

    public function canNotResend(CoreModel $model);

    public function isBlocked(CoreModel $model): bool;

    public function isBlockExpired(CoreModel $model): bool;

    public function blockPhone(CoreModel $model);

    public function unblockPhone(CoreModel $model);

    public function isOutOfTries(CoreModel $model): bool;

    public function isOutOfResendLimit(CoreModel $model): bool;

    public function SmsExpirySeconds(CoreModel $model): bool;

    public function isPhoneBlocked(string $phone): bool;

    public function delete(string $phone);
}
