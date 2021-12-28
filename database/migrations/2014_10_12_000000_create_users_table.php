<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->enum('userType', ['client', 'copywriter', 'freelancer', 'admin'])->default('client');
            $table->tinyInteger('isCompany')->default(0);
            $table->string('companyName')->nullable();
            $table->string('apartment_number')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('post_code')->nullable();
            $table->string('bank_account')->nullable();
            $table->bigInteger('tax_office_id')->nullable();
            $table->enum('status', ['active', 'pending', 'reject'])->default('pending');
            $table->string('request_string')->nullable();
            $table->string('vat_number')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
