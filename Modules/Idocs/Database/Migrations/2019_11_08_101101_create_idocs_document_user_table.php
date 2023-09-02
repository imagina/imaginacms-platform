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
        Schema::create('idocs__document_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id')->nallable();
            $table->integer('user_id')->nallable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('idocs__document_user');
    }
};
