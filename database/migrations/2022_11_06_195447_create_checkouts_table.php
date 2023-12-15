<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rentout_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('building_id')->nullable();
            $table->float('total', 16, 2);
            $table->float('tax', 16, 2)->nullable()->default(0);
            $table->enum('security_deposit_payment_mode', paymentModeOptions())->default('Direct Payment');
            $table->float('security_amount', 16, 2)->nullable()->default(0);
            $table->text('security_reason')->nullable();
            $table->float('booking_discount_amount', 16, 2)->nullable()->default(0);
            $table->float('special_discount_amount', 16, 2)->nullable()->default(0);
            $table->string('special_discount_reason')->nullable();
            $table->float('additional_charges', 16, 2)->nullable()->default(0);
            $table->text('additional_charge_comments')->nullable();
            $table->float('grand_total', 16, 2);
            $table->float('advance_amount', 16, 2)->nullable()->default(0);
            $table->float('paid', 16, 2)->nullable()->default(0);
            $table->float('balance', 16, 2)->nullable()->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('rentout_id')->references('id')->on('rentouts');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
};
