<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplacesSpaceTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplaces__space_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('meta_title');
            $table->text('meta_keywords');
            $table->text('meta_description');

            $table->text('options')->nullable();

            $table->integer('space_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['space_id', 'locale']);
            $table->foreign('space_id')->references('id')->on('iplaces__spaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iplaces__space_translations', function (Blueprint $table) {
            $table->dropForeign(['space_id']);
        });
        Schema::dropIfExists('iplaces__space_translations');
    }
}
