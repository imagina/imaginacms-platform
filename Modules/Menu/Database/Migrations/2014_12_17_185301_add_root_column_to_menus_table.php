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
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->boolean('is_root')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->dropColumn('is_root');
        });
    }
};
