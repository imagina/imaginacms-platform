<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbookingResourceTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ibooking__resource_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      $table->string('title');
      $table->text('description');
      $table->string('slug')->index();

      $table->integer('resource_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['resource_id', 'locale']);
      $table->foreign('resource_id')->references('id')->on('ibooking__resources')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('ibooking__resource_translations', function (Blueprint $table) {
      $table->dropForeign(['resource_id']);
    });
    Schema::dropIfExists('ibooking__resource_translations');
  }
}
