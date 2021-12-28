<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayUSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_u_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('environment', ['secure', 'sandbox']);
            $table->string('merchantPosId');
            $table->string('signatureKey');
            $table->string('oAuthClientId');
            $table->string('oAuthClientSecret');

            $table->enum('oAuthGrantType', ['client_credentials', 'trusted_merchant'])
                ->default('client_credentials');
            $table->string('oAuthEmail')->nullable();
            $table->string('oAuthExtCustomerID')->nullable();
            $table->timestamps();

            $table->index(['environment']);
            $table->index(['oAuthGrantType']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_u_s');
    }
}
