<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(AdminSeeder::class);
         \App\Models\User::factory(2)->create();
         \App\Models\User::factory(2)->create();
         \App\Models\User::factory(4)->create();
         \App\Models\User::factory(4)->create();
    }
}
