<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('qreable__qred', function (Blueprint $table) {
            $table->string('zone')->nullable();
            $table->string('redirect')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qreable__qred', function (Blueprint $table) {
            $table->dropColumn(['zone', 'redirect']);
        });
    }
};
