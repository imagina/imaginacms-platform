<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('ilocations__geozones_countries_provinces', function (Blueprint $table) {
            $table->integer('city_id')->unsigned()->nullable()->default(0)->after('province_id');
            $table->integer('province_id')->unsigned()->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('ilocations__geozones_countries_provinces', function (Blueprint $table) {
            $table->dropColumn('city_id');
        });
    }
};
