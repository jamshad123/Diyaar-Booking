<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserHasRoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_has_roles')->truncate();
        $data = [];
        $data[] = ['user_id' => 1,  'role_id' => 1]; // Admin
        $data[] = ['user_id' => 2,  'role_id' => 1]; // Admin

        $data[] = ['user_id' => 3,  'role_id' => 4]; //Manager
        $data[] = ['user_id' => 4,  'role_id' => 4]; //Manager
        $data[] = ['user_id' => 5,  'role_id' => 4]; //Manager

        $data[] = ['user_id' => 6,  'role_id' => 5]; //Receptionist
        $data[] = ['user_id' => 7,  'role_id' => 5]; //Receptionist
        $data[] = ['user_id' => 8,  'role_id' => 5]; //Receptionist

        $data[] = ['user_id' => 9,  'role_id' => 6]; //Collections
        $data[] = ['user_id' => 10, 'role_id' => 3]; //SuperVisor
        DB::table('user_has_roles')->insert($data);
    }
}
