<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['deposit','withdrawal','order','buy','sell','refund','fee','bonus'])->nullable();
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->string('ip',191)->nullable();
            $table->string('agent',191)->nullable();
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
        Schema::dropIfExists('stripe_logs');
    }
}
