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
        Schema::table('slider__slide_translations', function (Blueprint $table) {
            $table->text('summary')->nullable()->after('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('slider__slide_translations', function (Blueprint $table) {
            $table->dropColumn('summary');
        });
    }
};
