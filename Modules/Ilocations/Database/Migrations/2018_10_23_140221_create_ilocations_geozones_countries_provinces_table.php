<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIlocationsGeozonesCountriesProvincesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ilocations__geozones_countries_provinces', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('geozone_id')->unsigned();
            $table->foreign('geozone_id')->references('id')->on('ilocations__geozones')->onDelete('cascade');

            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('ilocations__countries')->onDelete('cascade');

            $table->integer('province_id')->unsigned()->nullable();
            $table->foreign('province_id')->references('id')->on('ilocations__provinces')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ilocations__geozones_countries_provinces', function (Blueprint $table) {
            $table->dropForeign(['geozone_id']);
            $table->dropForeign(['country_id']);
            $table->dropForeign(['province_id']);
        });
        Schema::dropIfExists('ilocations__geozones_countries_provinces');
    }
}
