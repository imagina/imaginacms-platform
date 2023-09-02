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
        Schema::create('iad__schedules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('iso');
            $table->string('name');
            $table->integer('ad_id')->unsigned();
            $table->foreign('ad_id')->references('id')->on('iad__ads')->onDelete('restrict');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('iad__schedules');
    }
};
