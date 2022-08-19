<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IformsAddAuditStampsInAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('iforms__forms', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('iforms__fields', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('iforms__leads', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('iforms__blocks', function (Blueprint $table) {
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
        //
    }
}