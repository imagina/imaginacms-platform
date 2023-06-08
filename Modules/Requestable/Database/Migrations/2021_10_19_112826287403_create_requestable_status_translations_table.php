<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestableStatusTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('requestable__status_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
  
      $table->string('title');
      
      $table->integer('status_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['status_id', 'locale']);
      $table->foreign('status_id')->references('id')->on('requestable__statuses')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('requestable__status_translations', function (Blueprint $table) {
      $table->dropForeign(['status_id']);
    });
    Schema::dropIfExists('requestable__status_translations');
  }
}
