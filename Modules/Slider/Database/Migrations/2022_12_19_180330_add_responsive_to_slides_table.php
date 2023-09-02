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
        Schema::table('slider__slides', function (Blueprint $table) {
            $table->integer('responsive')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
};
