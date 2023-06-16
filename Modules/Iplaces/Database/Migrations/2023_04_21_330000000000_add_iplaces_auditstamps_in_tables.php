<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIplacesAuditstampsInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iplaces__categories', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iplaces__cities', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iplaces__places', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iplaces__schedules', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iplaces__services', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iplaces__spaces', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iplaces__zones', function (Blueprint $table) {
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
