<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLngInAdsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    Schema::table('iad__ads', function (Blueprint $table) {

      $table->string('lat')->nullable();
      $table->string('lng')->nullable();
      
    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {

    Schema::table('iad__ads', function (Blueprint $table) {
      
      $table->dropColumn('lat');
      $table->dropColumn('lng');

    });

  }
}
