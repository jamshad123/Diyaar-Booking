<?php

use App\Models\Rentout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rentouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('checkout_id')->nullable();
            $table->unsignedBigInteger('customer_id')->index();
            $table->integer('registration_no')->nullable();
            $table->integer('booking_no');
            $table->string('reference_no')->nullable();
            $table->string('arrival_from')->nullable();
            $table->string('purpose_of_visit')->nullable();
            $table->datetime('check_in_date');
            $table->datetime('check_out_date');
            $table->integer('extra_beds')->default(0);
            $table->float('single_extra_bed_charge', 16, 2)->default(0);
            $table->float('extra_bed_charge', 16, 2)->default(0);
            $table->integer('no_of_adult')->default(0)->nullable();
            $table->integer('no_of_children')->default(0)->nullable();
            $table->float('total', 16, 2)->default(0);
            $table->float('tax_percentage', 16, 2)->default(0);
            $table->float('tax', 16, 2)->default(0);
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->string('coupon_code')->nullable();
            $table->float('discount_percentage', 16, 2)->nullable()->default(0);
            $table->float('discount_amount', 16, 2)->nullable()->default(0);
            $table->string('discount_reason')->nullable();
            $table->enum('payment_mode', paymentModeOptions())->default('Direct Payment');
            $table->float('advance_amount', 16, 2)->nullable()->default(0);
            $table->string('advance_reason')->nullable();
            $table->float('grand_total', 16, 2)->default(0);
            $table->enum('security_deposit_payment_mode', paymentModeOptions())->default('Direct Payment');
            $table->float('security_amount', 16, 2)->nullable()->default(0);
            $table->string('remarks')->nullable();
            $table->enum('status', Rentout::statusOptions())->default('Check In');
            $table->enum('flag', Rentout::flagOptions())->default('Pending');
            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->index();
            $table->foreign('agent_id')->references('id')->on('agents');
            $table->foreign('building_id')->references('id')->on('buildings');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rentouts');
    }
};
