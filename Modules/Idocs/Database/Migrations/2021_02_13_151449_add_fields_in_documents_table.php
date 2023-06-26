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
        Schema::table('idocs__documents', function (Blueprint $table) {
            $table->boolean('private')->default(false);
            $table->integer('downloaded')->default(0);
        });

        Schema::table('idocs__document_user', function (Blueprint $table) {
            $table->string('key')->nullable();
            $table->integer('downloaded')->default(0);
        });

        Schema::table('idocs__categories', function (Blueprint $table) {
            $table->integer('parent_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
