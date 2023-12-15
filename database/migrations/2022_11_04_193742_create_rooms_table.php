<?php

use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->index();
            $table->integer('room_no');
            $table->string('floor')->nullable();
            $table->enum('type', Room::typeOptions())->default(Room::Double);
            $table->integer('capacity')->nullable()->default('0');
            $table->integer('extra_capacity')->nullable()->default('0');
            $table->integer('no_of_beds')->nullable()->default('0');
            $table->decimal('amount', 16, 2)->nullable()->default('0');
            $table->enum('hygiene_status', Room::hygieneStatusOptions())->default(Room::Clean);
            $table->enum('status', Room::statusOptions())->default(Room::Active);
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->text('reserve_condition')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};
