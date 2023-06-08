<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestableFieldsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('requestable__fields', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields...
      
      $table->integer('requestable_id')->unsigned();
      $table->foreign('requestable_id')
        ->references('id')
        ->on('requestable__requestables')
        ->onDelete('cascade');
      
      $table->string('name')->nullable();
      $table->text('value')->nullable();
      $table->string('type')->nullable();
      
      // Audit fields
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
    Schema::dropIfExists('requestable__fields');
  }
}
