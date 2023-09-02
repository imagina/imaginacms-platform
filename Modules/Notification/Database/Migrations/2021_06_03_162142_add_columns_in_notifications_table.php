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
        Schema::table('notification__notifications', function (Blueprint $table) {
            $table->text('options')->after('is_read')->nullable();
            $table->boolean('is_action')->after('is_read')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification__notifications', function (Blueprint $table) {
            $table->dropColumn('options');
            $table->dropColumn('is_action');
        });
    }
};
