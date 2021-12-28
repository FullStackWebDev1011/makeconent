<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->string('title');
            $table->string('seller_title')->nullable();
            $table->text('description')->nullable();
            $table->integer('min_chars');
            $table->float('rate');
            $table->tinyInteger('cp_write_title')->default(0);
            $table->tinyInteger('cp_bold_keyword')->default(0);
            $table->enum('payment_method', ['PayU', 'wallet'])->default('PayU');
            $table->string('quality')->default('q1');
            $table->enum('status', ['sketch', 'open', 'pending', 'written', 'amendment', 'accepted', 'cancel', 'finish', 'rejected', 'checking_plagiarism'])->default('open');
            $table->float('budget')->nullable();
            $table->text('text')->nullable();
            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['category_id']);
            $table->index(['order_id']);
            $table->index(['seller_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
