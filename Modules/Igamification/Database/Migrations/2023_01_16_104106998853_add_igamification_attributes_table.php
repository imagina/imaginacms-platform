<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIgamificationAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('igamification__categories', function (Blueprint $table) {
            $table->integer('status')->default(1)->unsigned();
        });

        Schema::table('igamification__activities', function (Blueprint $table) {
            $table->integer('type')->default(1)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('igamification__categories', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
        Schema::table('igamification__activities', function (Blueprint $table) {
            $table->dropColumn(['type']);
        });
    }
}
