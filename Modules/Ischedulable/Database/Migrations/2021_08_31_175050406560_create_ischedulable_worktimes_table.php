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
        Schema::create('ischedulable__work_times', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->integer('schedule_id')->unsigned();
            $table->foreign('schedule_id')->references('id')->on('ischedulable__schedules')->onDelete('cascade');
            $table->integer('day_id')->unsigned();
            $table->foreign('day_id')->references('iso')->on('ischedulable__days');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('shift_time')->default(30)->nullable();
            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ischedulable__work_times');
    }
};
