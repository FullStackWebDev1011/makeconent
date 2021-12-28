<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id'); // seller Id --- freelancer
            $table->integer('category_id');
            $table->bigInteger('buyer_id')->nullable(); // buyer (client)'s Id who buy this sell
            $table->enum('status', ['open', 'finish', 'cancel', 'pending'])->default('pending');
            $table->string('title');
            $table->text('text');
            $table->float('budget')->default(0);
            $table->string('keyword')->nullable();
            $table->float('rate')->default(0);
            $table->bigInteger('nChars')->default(0);
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['category_id']);
            $table->index(['buyer_id']);
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
        Schema::dropIfExists('sells');
    }
}
