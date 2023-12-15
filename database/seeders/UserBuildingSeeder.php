<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserBuildingSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_buildings')->truncate();
        $buildings = DB::table('buildings')->get();
        $users = DB::table('users')->get();
        $data = [];
        foreach ($buildings as $building) {
            foreach ($users as $user) {
                $data[] = ['user_id' => $user->id, 'building_id' => $building->id];
            }
        }
        DB::table('user_buildings')->insert($data);
    }
}
