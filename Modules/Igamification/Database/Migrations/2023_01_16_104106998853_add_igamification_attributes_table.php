<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIgamificationAttributesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('igamification__categories', function (Blueprint $table) {
      $table->integer('status')->default(1)->unsigned();
    });

    Schema::table('igamification__activities', function (Blueprint $table) {
      $table->integer('type')->default(1)->unsigned();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('igamification__categories', function (Blueprint $table) {
      $table->dropColumn(['status']);
    });
    Schema::table('igamification__activities', function (Blueprint $table) {
      $table->dropColumn(['type']);
    });
  }
}
