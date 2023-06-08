<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcreditCreditsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icredit__credits', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('customer_id')->unsigned();
      $table->foreign('customer_id')->references('id')->on('users')->onDelete('restrict');
      $table->integer('admin_id')->nullable();
      $table->string('description')->nullable();
      $table->timestamp('date');
      $table->decimal('amount', 16, 2);
      $table->integer('status')->unsigned()->default(1);
      $table->integer('related_id')->nullable();
      $table->string('related_type')->nullable();
      
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
    Schema::dropIfExists('icredit__credits');
  }
}
