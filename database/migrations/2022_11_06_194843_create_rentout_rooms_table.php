<?php

use App\Models\Rentout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rentout_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rentout_id');
            $table->unsignedBigInteger('building_id')->nullable();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->time('check_in_time');
            $table->time('check_out_time');
            $table->float('amount', 16, 2);
            $table->integer('no_of_days');
            $table->float('total', 16, 2);
            $table->integer('no_of_adult')->default(0)->nullable();
            $table->integer('no_of_children')->default(0)->nullable();
            $table->enum('status', Rentout::statusOptions())->default('Check In');
            $table->foreign('rentout_id')->references('id')->on('rentouts')->onDelete('cascade');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rentout_rooms');
    }
};
