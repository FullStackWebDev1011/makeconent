<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->float('q1_min')->nullable(); // for example: "6,8" : here 6->min_price, 8->max_price
            $table->float('q1_max')->nullable();
            $table->float('q2_min')->nullable();
            $table->float('q2_max')->nullable();
            $table->float('q3_min')->nullable();
            $table->float('q3_max')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
