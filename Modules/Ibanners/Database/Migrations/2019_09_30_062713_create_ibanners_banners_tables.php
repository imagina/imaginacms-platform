<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ibanners__banners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order')->unsigned()->default(0);
            $table->string('type')->default('')->nullable();
            $table->text('external_image_url')->nullable();
            $table->string('target', 10)->nullable();
            $table->integer('position_id')->unsigned();
            $table->foreign('position_id')->references('id')->on('ibanners__positions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('ibanners__banners');
    }
};
