<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIgamificationActivityPositionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('igamification__activities', function (Blueprint $table) {
            $table->integer('position')->after('options')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('igamification__activities', function (Blueprint $table) {
            $table->dropColumn(['position']);
        });
    }
}
