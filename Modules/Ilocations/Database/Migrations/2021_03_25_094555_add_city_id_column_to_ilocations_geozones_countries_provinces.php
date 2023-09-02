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
        Schema::table('ilocations__geozones_countries_provinces', function (Blueprint $table) {
            $table->integer('city_id')->unsigned()->nullable()->default(0)->after('province_id');
            $table->integer('province_id')->unsigned()->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ilocations__geozones_countries_provinces', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
    }
};
