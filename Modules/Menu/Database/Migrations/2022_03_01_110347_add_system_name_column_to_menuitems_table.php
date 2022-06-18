<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSystemNameColumnToMenuitemsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('menu__menuitems', function (Blueprint $table) {
      $table->string('system_name')->after('page_id')->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('menu__menuitems', function (Blueprint $table) {
      $table->dropColumn('page_id');
    });
  }
}
