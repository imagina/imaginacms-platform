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
        Schema::table('requestable__statuses', function (Blueprint $table) {
            $table->integer('value')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
};
