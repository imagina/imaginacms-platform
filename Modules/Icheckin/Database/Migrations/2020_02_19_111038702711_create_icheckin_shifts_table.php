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
        Schema::create('icheckin__shifts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->timestamp('checkin_at')->nullable();
            $table->timestamp('checkout_at')->nullable();
            $table->unsignedInteger('checkin_by')->nullable();
            $table->unsignedInteger('checkout_by')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->string('geo_location')->nullable();

            $table->integer('request_id')->unsigned()->nullable();
            $table->integer('approval_id')->unsigned()->nullable();
            $table->integer('period_elapsed')->unsigned()->nullable();

            $table->text('options')->nullable();
            $table->integer('job_id')->unsigned()->nullable();
            $table->foreign('job_id')->references('id')->on('icheckin__jobs');

            //foreign Keys
            $table->foreign('checkin_by')->references('id')->on('users');
            $table->foreign('checkout_by')->references('id')->on('users');

            // Your fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('icheckin__shifts');
    }
};
