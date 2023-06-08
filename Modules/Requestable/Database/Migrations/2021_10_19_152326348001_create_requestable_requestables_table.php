<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestableRequestablesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('requestable__requestables', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      
      $table->increments('id');
      
      $table->string('requestable_type')->nullable();
      $table->string('requestable_id')->nullable();
      
      $table->string('type')->index();
      $table->integer('status_id')->default(1)->unsigned();
      $table->foreign('status_id')->references('id')->on('requestable__statuses')->onDelete('restrict');
  
      $table->integer('category_id')->unsigned();
      $table->foreign('category_id')->references('id')->on('requestable__categories')->onDelete('restrict');
      
      $table->timestamp('eta')->nullable(); //estimated time of accomplishment
      
      
      // Your fields
      $table->timestamps();
      $table->auditStamps();
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('requestable__requestables');
  }
}
