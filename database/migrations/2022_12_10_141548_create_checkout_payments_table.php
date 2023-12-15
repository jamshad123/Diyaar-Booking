<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('checkout_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkout_id')->nullable();
            $table->enum('payment_mode', paymentModeOptions())->default('Direct Payment');
            $table->float('amount', 16, 2);
            $table->foreign('checkout_id')->references('id')->on('checkouts');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkout_payments');
    }
};
