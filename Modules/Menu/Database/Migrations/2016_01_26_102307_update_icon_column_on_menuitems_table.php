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
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->string('icon')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->string('icon')->default('')->nullable(false)->change();
        });
    }
};
