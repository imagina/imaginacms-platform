<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
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
     *
     * @return void
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
}
