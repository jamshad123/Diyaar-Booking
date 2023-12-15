<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('agents', function (Blueprint $table) {
            if (! Schema::hasColumn('agents', 'code')) {
                $table->string('code')->nullable()->after('last_name');
            }
        });
    }

    public function down()
    {
        Schema::table('agents', function (Blueprint $table) {
            if (Schema::hasColumn('agents', 'code')) {
                $table->dropColumn('code');
            }
        });
    }
};
