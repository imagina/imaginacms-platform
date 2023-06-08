<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbookingServiceTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ibooking__service_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      $table->string('title');
      $table->text('description');
      $table->string('slug')->index();

      $table->integer('service_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['service_id', 'locale']);
      $table->foreign('service_id')->references('id')->on('ibooking__services')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('ibooking__service_translations', function (Blueprint $table) {
      $table->dropForeign(['service_id']);
    });
    Schema::dropIfExists('ibooking__service_translations');
  }
}
