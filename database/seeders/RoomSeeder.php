<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rooms')->truncate();
        $buildings = DB::table('buildings')->pluck('id', 'id');
        $rooms = [
            1 => 14,
            2 => 13,
            3 => 11,
            4 => 11,
            5 => 12,
            6 => 16,
        ];
        $floors = [
            1 => 10,
            2 => 10,
            3 => 10,
            4 => 10,
            5 => 10,
            6 => 10,
        ];
        $data = [];
        $type = ['Double', 'Triple', 'Quad', 'Quint', 'King'];
        $hygiene_status = ['Clean', 'Dirty'];
        $hygiene_status = ['Clean', 'Clean'];
        $status = ['Occupied', 'Vacant', 'Booked', 'Maintenance'];
        $status = ['Active', 'Maintenance'];
        foreach ($buildings as $building_id) {
            for ($room = 1; $room <= $rooms[$building_id]; $room++) {
                for ($floor = 1; $floor <= $floors[$building_id]; $floor++) {
                    $data[] = [
                        'building_id' => $building_id,
                        'room_no' => ($floor * 100) + $room,
                        'floor' => 'F'.$floor,
                        'amount' => 100,
                        'no_of_beds' => 4,
                        'type' => $type[shuffle($type)],
                        'hygiene_status' => $hygiene_status[shuffle($hygiene_status)],
                        'status' => $status[shuffle($status)],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        DB::table('rooms')->insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
