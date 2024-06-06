<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationRulesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notification__rules', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string("name");
      $table->string("entity_name");
      $table->text("event_path");
      $table->boolean("status")->default(false);
      $table->text("conditions")->nullable();
      $table->text("settings")->nullable();
      // Your fields
      $table->timestamps();
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('notification__rules');
  }
}
