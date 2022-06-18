<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PageAddExtraFieldsPageTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('page__pages', function (Blueprint $table) {
      $table->string('system_name')->nullable()->after("internal");
      $table->string('type')->nullable()->after("internal");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('page__pages', function (Blueprint $table) {
      $table->dropColumn(['type', 'system_name']);
    });
  }
}
