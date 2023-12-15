<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (! Schema::hasColumn('coupons', 'expiry_at')) {
                $table->date('expiry_at')->after('used_by')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (Schema::hasColumn('coupons', 'expiry_at')) {
                $table->dropColumn('expiry_at');
            }
        });
    }
};
