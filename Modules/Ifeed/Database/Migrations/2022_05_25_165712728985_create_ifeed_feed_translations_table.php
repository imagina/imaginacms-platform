<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfeedFeedTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifeed__feed_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('feed_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['feed_id', 'locale']);
            $table->foreign('feed_id')->references('id')->on('ifeed__feeds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ifeed__feed_translations', function (Blueprint $table) {
            $table->dropForeign(['feed_id']);
        });
        Schema::dropIfExists('ifeed__feed_translations');
    }
}
