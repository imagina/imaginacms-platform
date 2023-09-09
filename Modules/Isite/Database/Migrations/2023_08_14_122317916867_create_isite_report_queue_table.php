<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('isite__report_queue', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields...
      $table->string('report');
      $table->integer('user_id')->unsigned();
      $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
      $table->timestamp('start_date', 0)->nullable();
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
    Schema::dropIfExists('isite__report_queue');
  }
};
