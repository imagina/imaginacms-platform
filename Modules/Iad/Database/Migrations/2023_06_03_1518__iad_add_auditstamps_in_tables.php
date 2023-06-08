<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IadAddAuditstampsInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('iad__ad_up', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('iad__fields', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('iad__schedules', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('iad__ups', function (Blueprint $table) {
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
