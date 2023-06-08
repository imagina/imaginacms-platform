<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrialColumnIplanTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('iplan__plans', function (Blueprint $table) {
      $table->integer('trial')->unsigned()->default(0)->after('type');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('iplan__plans', function (Blueprint $table) {
      $table->dropColumn('trial');
    });
  }
}
