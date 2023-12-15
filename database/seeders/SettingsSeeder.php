<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->truncate();
        $buildings = DB::table('buildings')->get();
        $data = [];
        $data[] = ['key' => 'tax_percentage', 'values' => '17.5'];
        foreach ($buildings as $key => $value) {
            $data[] = ['key' => 'minimum_room_rent_building_id_'.$value->id, 'values' => '100'];
            $data[] = ['key' => 'vat_registration_no_building_id_'.$value->id, 'values' => '310846178700003'];
        }
        $data[] = ['key' => 'extra_bed_charge', 'values' => '20'];
        DB::table('settings')->insert($data);
    }
}
