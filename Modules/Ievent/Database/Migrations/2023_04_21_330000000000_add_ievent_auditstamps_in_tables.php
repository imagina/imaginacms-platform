<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIeventAuditstampsInTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ievent__attendants', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('ievent__categories', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('ievent__comments', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('ievent__recurrences', function (Blueprint $table) {
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
