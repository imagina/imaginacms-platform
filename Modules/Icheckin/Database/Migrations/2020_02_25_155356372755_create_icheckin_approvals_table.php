<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcheckinApprovalsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icheckin__approvals', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->unsignedInteger('user_id')->nullable();
      $table->unsignedInteger('department_id')->nullable();
      $table->unsignedInteger('approved_by')->nullable();
      $table->date('date')->nullable();
      $table->integer('period_approved')->nullable();
      
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
    Schema::dropIfExists('icheckin__approvals');
  }
}
