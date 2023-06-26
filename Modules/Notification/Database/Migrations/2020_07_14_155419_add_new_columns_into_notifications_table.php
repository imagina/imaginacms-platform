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
            $table->string('recipient')->after('message')->nullable();
            $table->string('provider')->after('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification__notifications', function (Blueprint $table) {
            $table->dropColumn('recipient');
            $table->dropColumn('provider');
        });
    }
};
