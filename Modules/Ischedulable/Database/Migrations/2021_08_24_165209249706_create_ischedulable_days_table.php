<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIschedulableDaysTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ischedulable__days', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->integer('iso')->unsigned();
      $table->tinyInteger('status')->default(1)->unsigned();
      $table->unique(['iso']);

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
    Schema::dropIfExists('ischedulable__days');
  }
}
