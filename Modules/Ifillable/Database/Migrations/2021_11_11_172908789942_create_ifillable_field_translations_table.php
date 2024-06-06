<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfillableFieldTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ifillable__field_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      $table->text('value')->nullable();
      $table->integer('field_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['field_id', 'locale']);
      $table->foreign('field_id')->references('id')->on('ifillable__fields')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('ifillable__field_translations', function (Blueprint $table) {
      $table->dropForeign(['field_id']);
    });
    Schema::dropIfExists('ifillable__field_translations');
  }
}
