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
        Schema::table('ilocations__neighborhoods', function (Blueprint $table) {
            $table->integer('country_id')->unsigned()->after('city_id');
            $table->foreign('country_id')->references('id')->on('ilocations__countries')->onDelete('cascade');

            $table->integer('province_id')->unsigned()->after('city_id');
            $table->foreign('province_id')->references('id')->on('ilocations__provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
