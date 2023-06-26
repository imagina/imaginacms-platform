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
        Schema::table('requestable__automation_rules', function (Blueprint $table) {
            $table->string('to')->nullable()->after('category_rule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requestable__automation_rules', function (Blueprint $table) {
            $table->dropColumn('to');
        });
    }
};
