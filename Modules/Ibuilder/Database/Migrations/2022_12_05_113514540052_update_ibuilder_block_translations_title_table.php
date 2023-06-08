<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIbuilderBlockTranslationsTitleTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('ibuilder__block_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->renameColumn('title', 'internal_title');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
  }
}
