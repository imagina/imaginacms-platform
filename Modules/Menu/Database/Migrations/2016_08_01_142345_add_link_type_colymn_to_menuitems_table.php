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
            $table->string('link_type')->after('target')->default('page');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('menu__menuitems', function (Blueprint $table) {
            $table->dropColumn('link_type');
        });
    }
};
