<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionsColumnInAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iprofile__addresses', function (Blueprint $table) {
  
          $table->text('options')->nullable();
          $table->boolean('default')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iprofile__addresses', function (Blueprint $table) {
  
          $table->dropColumn('options');
          $table->dropColumn('default');
        });
    }
}
