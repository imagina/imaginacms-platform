<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIprofileFieldsAddressesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('iprofile__addresses', function (Blueprint $table) {
      
      $table->integer('country_id')->unsigned()->nullable();
      $table->integer('state_id')->unsigned()->nullable();
      $table->integer('city_id')->unsigned()->nullable();
      $table->integer('neighborhood_id')->unsigned()->nullable();
      $table->string('neighborhood')->nullable();
      
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {

    Schema::table('iprofile__addresses', function($table) {
      $table->dropColumn('country_id');
      $table->dropColumn('state_id');
      $table->dropColumn('city_id');
      $table->dropColumn('neighborhood_id');
      $table->dropColumn('neighborhood');
    });

  }
}
