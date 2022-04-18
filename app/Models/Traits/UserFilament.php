<?php

namespace App\Models\Traits;

trait UserFilament
{
    public function canAccessFilament(): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->full_name;
    }


    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar->url_1024 ?? null;
    }
}
