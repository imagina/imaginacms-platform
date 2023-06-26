<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('iprofile__addresses', function (Blueprint $table) {
            $table->text('options')->nullable();
            $table->boolean('default')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('iprofile__addresses', function (Blueprint $table) {
            $table->dropColumn('options');
            $table->dropColumn('default');
        });
    }
};
