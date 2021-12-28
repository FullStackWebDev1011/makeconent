<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_renewals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',20);
            $table->string('email',191);
            $table->double('amount', 8, 2);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
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
        Schema::dropIfExists('user_renewals');
    }
}
