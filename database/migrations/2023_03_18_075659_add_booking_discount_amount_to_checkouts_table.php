<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            if (! Schema::hasColumn('checkouts', 'booking_discount_amount')) {
                $table->float('booking_discount_amount', 16, 2)->default(0)->after('security_reason')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            if (Schema::hasColumn('checkouts', 'booking_discount_amount')) {
                $table->dropColumn('booking_discount_amount');
            }
        });
    }
};
