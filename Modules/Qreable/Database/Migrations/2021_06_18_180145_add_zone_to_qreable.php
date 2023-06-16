<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZoneToQreable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qreable__qred', function (Blueprint $table) {
            $table->string('zone')->nullable();
            $table->string('redirect')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qreable__qred', function (Blueprint $table) {
            $table->dropColumn(['zone', 'redirect']);
        });
    }
}
