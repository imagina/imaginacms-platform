<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIpayPaymentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ipay__payment', function (Blueprint $table) {
            $table->increments('id');

            $table->string('buyerfullname', 255);
            $table->string('description', 255);
            $table->integer('status');
            $table->string('amount', 255);

            $table->text('options')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipay_payment');
    }
}
