<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->float('amount', 16, 2)->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('used_by')->nullable();
            $table->unsignedBigInteger('rentout_id')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('used_by')->references('id')->on('users');
            $table->date('expiry_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
