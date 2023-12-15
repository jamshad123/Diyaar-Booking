<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        $data = [];
        $data[] = ['flag' => '1', 'name' => 'Super Admin'];
        $data[] = ['flag' => '1', 'name' => 'MD'];
        $data[] = ['flag' => '1', 'name' => 'Supervisor'];
        $data[] = ['flag' => '1', 'name' => 'Manager'];
        $data[] = ['flag' => '1', 'name' => 'Receptionist'];
        $data[] = ['flag' => '1', 'name' => 'Collection'];
        DB::table('roles')->insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
