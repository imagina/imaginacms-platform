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
        Schema::table('iplan__plans', function (Blueprint $table) {
            $table->integer('trial')->unsigned()->default(0)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iplan__plans', function (Blueprint $table) {
            $table->dropColumn('trial');
        });
    }
};
