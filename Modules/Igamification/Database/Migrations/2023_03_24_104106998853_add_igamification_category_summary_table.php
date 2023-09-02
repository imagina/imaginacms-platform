<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('igamification__category_translations', function (Blueprint $table) {
            $table->text('summary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('igamification__category_translations', function (Blueprint $table) {
            $table->dropColumn(['summary']);
        });
    }
};
