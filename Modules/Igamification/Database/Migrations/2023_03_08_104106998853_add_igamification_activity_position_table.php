<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIgamificationActivityPositionTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('igamification__activities', function (Blueprint $table) {
      $table->integer('position')->after("options")->unsigned()->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('igamification__activities', function (Blueprint $table) {
      $table->dropColumn(['position']);
    });
  }
}
