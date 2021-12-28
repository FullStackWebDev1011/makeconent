<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompAddressUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {            
            $table->string('comp_apartment_number',191)->after('post_code')->nullable();
            $table->string('comp_street',191)->after('comp_apartment_number')->nullable();
            $table->string('comp_city',191)->after('comp_street')->nullable();
            $table->string('comp_post_code',191)->after('comp_city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
