<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInternalColumnInDepartmentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('iprofile__departments', function (Blueprint $table) {
      $table->integer('internal')->default(0)->nullable()->after('parent_id');
      $table->integer('parent_id')->default(0)->nullable()->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('iprofile__departments', function (Blueprint $table) {
      $table->dropColumn('internal');
    });
  }
}
