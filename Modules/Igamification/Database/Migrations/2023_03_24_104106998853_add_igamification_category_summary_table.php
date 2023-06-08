<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIgamificationCategorySummaryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('igamification__category_translations', function (Blueprint $table) {
      $table->text('summary')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('igamification__category_translations', function (Blueprint $table) {
      $table->dropColumn(['summary']);
    });
  }
}
