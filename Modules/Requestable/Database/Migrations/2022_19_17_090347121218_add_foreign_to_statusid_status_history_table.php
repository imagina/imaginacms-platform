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
        Schema::table('requestable__status_history', function (Blueprint $table) {
            $table->integer('status_id')->unsigned()->change();
            $table->foreign('status_id')->references('id')->on('requestable__statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
};
