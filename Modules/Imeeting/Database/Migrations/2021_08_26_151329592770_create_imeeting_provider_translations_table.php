<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImeetingProviderTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imeeting__provider_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->string('title');
            $table->text('description');

            $table->integer('provider_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['provider_id', 'locale']);
            $table->foreign('provider_id')->references('id')->on('imeeting__providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imeeting__provider_translations', function (Blueprint $table) {
            $table->dropForeign(['provider_id']);
        });
        Schema::dropIfExists('imeeting__provider_translations');
    }
}
