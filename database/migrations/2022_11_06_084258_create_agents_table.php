<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('second_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->enum('customer_type', customerTypeOptions())->default('Citizen');
            $table->string('last_name')->nullable();
            $table->string('code')->nullable();
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('father_name')->nullable();
            $table->enum('gender', genderOptions())->default('Male');
            $table->string('occupation')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('anniversary')->nullable();
            $table->string('nationality')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('address')->nullable();
            $table->text('comments')->nullable();
            $table->enum('document_type', documentTypeOptions())->default('ID Card');
            $table->string('id_no')->nullable();
            $table->string('iqama_no')->nullable();
            $table->string('visa_no')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('qccid_no')->nullable();
            $table->string('issue_place')->nullable();
            $table->date('expiry_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agents');
    }
};
