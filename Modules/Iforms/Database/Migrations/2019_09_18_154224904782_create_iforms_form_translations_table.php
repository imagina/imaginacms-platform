<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIformsFormTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('iforms__form_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->integer('form_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['form_id', 'locale']);
            $table->foreign('form_id')->references('id')->on('iforms__forms')->onDelete('cascade');
        });
    }

      /**
       * Reverse the migrations.
       */
      public function down(): void
      {
          Schema::table('iforms__form_translations', function (Blueprint $table) {
              $table->dropForeign(['form_id']);
          });
          Schema::dropIfExists('iforms__form_translations');
      }
}
