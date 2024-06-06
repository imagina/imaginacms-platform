<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileAddressesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('iprofile__addresses', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('user_id')->unsigned();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->string('first_name');
      $table->string('last_name');
      $table->string('company')->nullable();
      $table->text('address_1');
      $table->text('address_2')->nullable();
      $table->string('city')->nullable();
      $table->string('zip_code')->nullable();
      $table->string('country')->nullable();
      $table->string('state')->nullable();
      $table->string('type')->nullable();
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
    Schema::dropIfExists('iprofile__addresses');
  }
}
