<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('iplaces__places', function (Blueprint $table) {
            $table->integer('site_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iplaces__places', function (Blueprint $table) {
            $table->dropColumn('site_id');
        });
    }
};
