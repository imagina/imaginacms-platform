<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IadAddAuditstampsInTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('iad__ad_up', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iad__fields', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iad__schedules', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iad__ups', function (Blueprint $table) {
            $table->auditStamps();
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
