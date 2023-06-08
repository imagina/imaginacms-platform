<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIsiteModuleTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('isite__module_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      $table->string('name');
      
      $table->integer('module_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['module_id', 'locale']);
      $table->foreign('module_id')->references('id')->on('isite__modules')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('isite__module_translations', function (Blueprint $table) {
      $table->dropForeign(['module_id']);
    });
    Schema::dropIfExists('isite__module_translations');
  }
}
