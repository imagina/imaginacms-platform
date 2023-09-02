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
        Schema::table('iplan__limits', function (Blueprint $table) {
            $table->integer('quantity')->unsigned(false)->change();
        });
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->integer('quantity')->unsigned(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iplan__limits', function (Blueprint $table) {
            $table->integer('quantity')->unsigned()->change();
        });
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->integer('quantity')->unsigned()->change();
        });
    }
};
