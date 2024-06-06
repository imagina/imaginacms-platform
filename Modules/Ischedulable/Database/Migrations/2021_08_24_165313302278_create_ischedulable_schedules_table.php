<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIschedulableSchedulesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ischedulable__schedules', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->string('zone');
      $table->tinyInteger('status')->default(1)->unsigned();
      $table->integer('entity_id');
      $table->string('entity_type');
      $table->timestamp('start_date', 0)->nullable();
      $table->timestamp('end_date', 0)->nullable();

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
    Schema::dropIfExists('ischedulable__schedules');
  }
}
