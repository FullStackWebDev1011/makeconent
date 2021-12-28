<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->float('qty');
            $table->float('fee')->default(0);
            $table->enum('type', ['free', 'express'])->default('free');
            $table->enum('status', ['pending', 'cancel', 'finish'])->default('pending');
            $table->date('finish_date')->nullable();
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['bill_id']);
            $table->index(['type']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraws');
    }
}
