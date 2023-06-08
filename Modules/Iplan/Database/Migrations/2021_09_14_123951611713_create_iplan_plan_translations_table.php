<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanPlanTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('iplan__plan_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      
      $table->string('name');
      $table->longText('description');
      $table->bigInteger('plan_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['plan_id', 'locale']);
      $table->foreign('plan_id')->references('id')->on('iplan__plans')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('iplan__plan_translations', function (Blueprint $table) {
      $table->dropForeign(['plan_id']);
    });
    Schema::dropIfExists('iplan__plan_translations');
  }
}
