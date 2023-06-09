<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWidthColumnToIformsFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->integer('width')->unsigned()->default(12);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->dropColumn('width');
        });
    }
}
