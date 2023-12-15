<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(UserSeeder::class);
        $this->call(BuildingSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserHasRoleSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserBuildingSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
