<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\{Permission, Role};
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\Finder\Finder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roleNames = [
            'superadmin' => ['uz' => 'super admin', 'ru' => "Супер администратор", 'en' => "super admin"],
            'call-center' => ['uz' => "qo'ng'iroq markazi", 'ru' => "Колл-центр", 'en' => "Call center"],
            'manager' => ['uz' => "Menejer", 'ru' => "Менеджер", 'en' => "Manager"],
            'driver' => ['uz' => "Haydovchi", 'ru' => "Водитель", 'en' => "Driver"],
            'dispatcher' => ['uz' => "Ekspeditor", 'ru' => "Экспедитор", 'en' => "Dispatcher"],
            'customer' => ['uz' => "Mijoz", 'ru' => "Заказчик", 'en' => "Customer"],
            'carrier' => ['uz' => "Kuryer", 'ru' => "Перевозчик", 'en' => "Carrier"],
        ];
        $roles = [];
        foreach ($roleNames as $key => $value) {
            $roles[] = [
                'title' => json_encode($value),
                'name' => $key,
                'guard_name' => 'api',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
//        $roles = collect($roleNames)->map(function ($role) {
//            return ['name' => $role,
//                'guard_name' => 'api',
//                'created_at' => now(),
//                'updated_at' => now()
//            ];
//        });
        Role::insert($roles);

        $finder = new Finder();
        $path = app_path() . '/Http/Controllers/Api/';
        $finder->in($path)->name('*.php')->notName('AuthController.php');
        $controllerNames = [];
        foreach ($finder as $f) {
            $controllerNames[] = Str::singular(str_replace('Controller.php', '', $f->getFilename()));
        }
        foreach ($controllerNames as $k => $name) {
            try {
                $commonPermissions = ['create', 'read', 'update', 'delete'];
                foreach ($commonPermissions as $key => $permission) {
                    $permissions[$key] = ['name' => mb_strtolower($permission . '-' . $name),
                        'guard_name' => 'api',
                        'created_at' => now(),
                        'updated_at' => now()];
                }
                Permission::insert($permissions);
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        $this->call(PermissionsSeeder::class);
    }
}
