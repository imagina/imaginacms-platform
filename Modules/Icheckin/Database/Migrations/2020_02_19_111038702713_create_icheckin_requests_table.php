<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcheckinRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icheckin__requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
  
          $table->timestamp('checkin_at')->nullable();
          $table->timestamp('checkout_at')->nullable();
          $table->string('geo_location')->nullable();
          
          $table->unsignedInteger('user_id')->nullable();
          
          $table->integer('status')->nullable();
          $table->integer('type')->nullable();
          
          $table->integer('shift_id')->unsigned()->nullable();
          $table->foreign('shift_id')->references('id')->on('icheckin__shifts');
          
  
          //foreign Keys
          $table->foreign('user_id')->references('id')->on('users');
          
            // Your fields
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
        Schema::dropIfExists('icheckin__requests');
    }
}
