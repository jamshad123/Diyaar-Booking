<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('buildings')->truncate();
        $data = [];
        $data[] = ['name' => 'DIYAR - AL MADINA'];
        // $data[] = ['name' => 'DIYAR WAHAT AL NAZIL'];
        // $data[] = ['name' => 'DIYAR - TABA'];
        // $data[] = ['name' => 'DIYAR NAKHEEL'];
        // $data[] = ['name' => 'DIYAR AL SALAM SILVER - A'];
        // $data[] = ['name' => 'DIYAR AL SALAM SILVER - B'];
        DB::table('buildings')->insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
