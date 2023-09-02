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
        Schema::table('iforms__forms', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iforms__leads', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('iforms__blocks', function (Blueprint $table) {
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
};
