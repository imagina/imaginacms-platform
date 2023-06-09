<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrefixAndSuffixToFields extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->string('suffix')->nullable()->after('order');
            $table->string('prefix')->nullable()->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->dropColumn('prefix');
            $table->dropColumn('suffix');
        });
    }
}
