<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWidthColumnToIformsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->integer('width')->unsigned()->default(12);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->dropColumn('width');
        });
    }
}
