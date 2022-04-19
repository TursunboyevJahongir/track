<?php

namespace App\Models;

use App\Helpers\TranslatableJson;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $casts = ['title' => TranslatableJson::class];

    public function getTitleArrayAttribute(): mixed
    {
        return json_decode($this->attributes['title'], false);
    }
}
