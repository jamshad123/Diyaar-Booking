<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        $data = [];
        $data[] = [
            'name' => 'Admin',
            'email' => 'admin@diyar.com',
            'password' => Hash::make('asdasd'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data[] = [
            'name' => 'Rahees',
            'email' => 'raheescv1992@gmail.com',
            'password' => Hash::make('asdasd'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data[] = [
            'name' => 'Manager_1',
            'email' => 'manager_1@diyar.com',
            'password' => Hash::make('manager_1@132'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data[] = [
            'name' => 'Manager_2',
            'email' => 'manager_2@diyar.com',
            'password' => Hash::make('manager_2@132'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data[] = [
            'name' => 'Manager_3',
            'email' => 'manager_3@diyar.com',
            'password' => Hash::make('manager_3@132'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data[] = [
            'name' => 'Receptionist_1',
            'email' => 'receptionist_1@diyar.com',
            'password' => Hash::make('receptionist_1@132'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data[] = [
            'name' => 'Receptionist_2',
            'email' => 'receptionist_2@diyar.com',
            'password' => Hash::make('receptionist_2@132'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data[] = [
            'name' => 'Receptionist_3',
            'email' => 'receptionist_3@diyar.com',
            'password' => Hash::make('receptionist_3@132'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data[] = [
            'name' => 'Collection',
            'email' => 'collection@diyar.com',
            'password' => Hash::make('collection@132'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $data[] = [
            'name' => 'Supervisor',
            'email' => 'supervisor@diyar.com',
            'password' => Hash::make('supervisor@132'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        DB::table('users')->insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
