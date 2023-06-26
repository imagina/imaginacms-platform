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
        Schema::table('page__pages', function (Blueprint $table) {
            $table->string('system_name')->nullable()->after('internal');
            $table->string('type')->nullable()->after('internal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('page__pages', function (Blueprint $table) {
            $table->dropColumn(['type', 'system_name']);
        });
    }
};
