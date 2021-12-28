<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->enum('status', ['open', 'bought']);
            $table->timestamps();

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
        Schema::dropIfExists('bonus_codes');
    }
}
