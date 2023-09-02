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
        Schema::table('iplaces__places', function (Blueprint $table) {
            $table->float('rating', 3, 2)->default('3');
            $table->boolean('validated')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iplaces__places', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
