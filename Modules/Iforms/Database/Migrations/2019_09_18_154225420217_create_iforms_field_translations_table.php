<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIformsFieldTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('iforms__field_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('label')->index();
      $table->string('placeholder');
      $table->string('description');
      $table->integer('field_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['field_id', 'locale']);
      $table->foreign('field_id')->references('id')->on('iforms__fields')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('iforms__field_translations', function (Blueprint $table) {
      $table->dropForeign(['field_id']);
    });
    Schema::dropIfExists('iforms__field_translations');
  }
}
