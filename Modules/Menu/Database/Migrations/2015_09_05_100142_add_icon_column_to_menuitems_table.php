<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIconColumnToMenuitemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('icon')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
}
