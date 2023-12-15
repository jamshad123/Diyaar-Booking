<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rentout_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rentout_id');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('rentout_id')->references('id')->on('rentouts')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rentout_customers');
    }
};
