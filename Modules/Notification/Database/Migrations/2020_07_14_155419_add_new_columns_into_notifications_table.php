<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsIntoNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('notification__notifications', function (Blueprint $table) {
      $table->string('recipient')->after('message')->nullable();
      $table->string('provider')->after('message')->nullable();
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('notification__notifications', function (Blueprint $table) {
      $table->dropColumn('recipient');
      $table->dropColumn('provider');
    });
  }
}
