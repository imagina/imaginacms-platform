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
        Schema::table('iblog__categories', function (Blueprint $table) {
            $table->boolean('internal')->default(false)->after('depth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
