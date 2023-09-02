<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('iplan__subscription_related', function (Blueprint $table) {
            $table->id();
            $table->integer('subscription_id')->unsigned();
            $table->string('related_type');
            $table->integer('related_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('iplan__subscription_related');
    }
};
