<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeQuantityFieldToLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iplan__limits', function (Blueprint $table) {
           $table->integer('quantity')->unsigned(false)->change();
        });
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->integer('quantity')->unsigned(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iplan__limits', function (Blueprint $table) {
            $table->integer('quantity')->unsigned()->change();
        });
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->integer('quantity')->unsigned()->change();
        });
    }
}
