<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileDepartmentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('iprofile__departments', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      // Your fields
      $table->string('title')->nullable();
      $table->text('options')->nullable();
      
      $table->integer('parent_id')->default(0);
      $table->integer('lft')->unsigned()->nullable();
      $table->integer('rgt')->unsigned()->nullable();
      $table->integer('depth')->unsigned()->nullable();
      
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
    Schema::dropIfExists('iprofile__departments');
  }
}
