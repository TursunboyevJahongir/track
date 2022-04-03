<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::findByName('superadmin');

        Permission::create(['guard_name' => 'api', 'name' => 'system']);
        $superadmin->syncPermissions(Permission::all());
    }
}
