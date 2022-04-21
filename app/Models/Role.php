<?php

namespace App\Models;

use App\Helpers\TranslatableJson;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $casts = ['title' => TranslatableJson::class];


    public function newQuery()
    {
        if (auth()->check() && auth()->hasPermissionTo('system')
            && auth()->user()->hasRole('superadmin'))
            return parent::newQuery();

        return parent::newQuery()->whereDoesntHave('permissions', function ($query) {
            $query->where('name', 'system');
        });
    }
}
