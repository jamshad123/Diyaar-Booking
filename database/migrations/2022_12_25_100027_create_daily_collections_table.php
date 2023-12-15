<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->datetime('opening_time');
            $table->datetime('closing_time')->nullable();
            $table->float('opening_balance', 16, 2)->default(0);
            $table->text('opening_note')->nullable();
            $table->float('closing_balance', 16, 2)->default(0)->nullable();
            $table->text('closing_note')->nullable();
            $table->enum('flag', ['Pending', 'Approved', 'Not Approved'])->default('Pending');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_collections');
    }
};
