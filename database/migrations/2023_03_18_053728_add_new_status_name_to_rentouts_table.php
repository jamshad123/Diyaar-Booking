<?php

use App\Models\Rentout;
use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $status = implode("','", Rentout::statusOptions());
        DB::statement("ALTER TABLE rentouts MODIFY column status ENUM('$status') default 'Check In' ");
        DB::statement("ALTER TABLE rentout_rooms MODIFY column status ENUM('$status') default 'Check In' ");
        $status = implode("','", Room::statusOptions());
        DB::statement("ALTER TABLE rooms MODIFY column status ENUM('$status') default 'Active' ");
    }

    public function down()
    {
    }
};
