<?php

namespace App\Models;

use App\Helpers\TranslatableJson;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $casts = ['title' => TranslatableJson::class];
}
