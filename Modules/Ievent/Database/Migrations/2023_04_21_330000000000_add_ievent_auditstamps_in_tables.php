<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIeventAuditstampsInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('ievent__attendants', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('ievent__categories', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('ievent__comments', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('ievent__recurrences', function (Blueprint $table) {
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
