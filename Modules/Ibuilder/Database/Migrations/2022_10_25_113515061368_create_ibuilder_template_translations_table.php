<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIbuilderTemplateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibuilder__template_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('template_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['template_id', 'locale']);
            $table->foreign('template_id')->references('id')->on('ibuilder__templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ibuilder__template_translations', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
        });
        Schema::dropIfExists('ibuilder__template_translations');
    }
}
