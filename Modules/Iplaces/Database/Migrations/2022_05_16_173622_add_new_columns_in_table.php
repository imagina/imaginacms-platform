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
        Schema::table('iplaces__places', function (Blueprint $table) {
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
        });
        Schema::table('iplaces__categories', function (Blueprint $table) {
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iplaces__places', function (Blueprint $table) {
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
        });
        Schema::table('iplaces__categories', function (Blueprint $table) {
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
        });
    }
};
