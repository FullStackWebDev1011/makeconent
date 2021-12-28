<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->enum('status', ['pending', 'success', 'cancel', 'finish'])->default('finish');
            $table->enum('type', ['deposit', 'withdrawal', 'order', 'buy', 'sell', 'refund', 'fee', 'bonus'])->nullable();
            $table->float('qty');
            $table->string('source')->nullable()->comment('card Number - deposit or withdrawal; orderId - order; sellId - buy or sell directly');
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['status']);
            $table->index(['type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
