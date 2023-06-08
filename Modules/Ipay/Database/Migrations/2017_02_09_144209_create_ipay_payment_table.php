<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpayPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipay__payment', function (Blueprint $table) {
            $table->increments('id');

            $table->string('buyerfullname',255);
            $table->string('description',255);
            $table->integer('status');
            $table->string('amount',255);

            $table->text('options')->nullable();

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
        Schema::dropIfExists('ipay_payment');
    }
}
