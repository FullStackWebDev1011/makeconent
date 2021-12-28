<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('fee')->default(15);
            $table->float('ratelimit')->default(75);
            $table->float('min_withdrawal_balance')->default(150);
            $table->integer('order_deadline_hours')->default(7); // default 7 hours
            $table->float('bonus_fee')->default(7); // default 7 hours
            $table->enum('environment', ['Development', 'Production'])->default('Development');
            $table->timestamps();

            $table->index(['environment']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
