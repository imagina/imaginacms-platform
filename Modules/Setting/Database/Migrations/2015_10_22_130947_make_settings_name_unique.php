<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('setting__settings', function (Blueprint $table) {
            $table->unique('name', 'setting__settings_name_unique');
            $table->index('name', 'setting__settings_name_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setting__settings', function (Blueprint $table) {
            $table->dropUnique('setting__settings_name_unique');
            $table->dropIndex('setting__settings_name_index');
        });
    }
};
