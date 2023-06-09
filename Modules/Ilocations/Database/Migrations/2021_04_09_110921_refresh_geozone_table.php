<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefreshGeozoneTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ilocations__geozones_countries_provinces', function (Blueprint $table) {
            $table->integer('city_id')->unsigned()->nullable()->default(null)->change();
            $table->integer('province_id')->unsigned()->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
}
