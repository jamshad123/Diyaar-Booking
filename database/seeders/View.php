<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class View extends Seeder
{
    public function run()
    {
        $data = [];
        $data[] = '2022_12_08_063152_create_room_date_views_table';
        $data[] = '2023_01_01_052150_create_journal_views_table';
        $data[] = '2023_03_17_172859_create_offer_views_table';
        DB::table('migrations')->whereIn('migration', $data)->delete();
        foreach ($data as $key => $value) {
            Artisan::call('migrate --path=database/migrations/'.$value.'.php');
        }
    }
}
