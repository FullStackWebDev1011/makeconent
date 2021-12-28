<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('source')->nullable(); // card Number
            $table->float('total_balance')->nullable();
            $table->float('credit_balance')->default(0); // no function for v1 version
            $table->string('bonus_code')->nullable();// for version 2: admin generate bonus codes and user can choose one of them.
            $table->float('bonus')->default(0); // funds from bonus, for version 2
            $table->timestamps();

            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
