<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('iad__ads', function (Blueprint $table) {
            $table->integer('sort_order')->unsigned()->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iad__ads', function (Blueprint $table) {
            $table->dropColumn(['sort_order']);
        });
    }
};
