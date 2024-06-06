<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIlocationsNeighborhoodTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilocations__neighborhood_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('name');
            $table->integer('neighborhood_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['neighborhood_id', 'locale'], 'neighborhood_neighborhood_id_locale_unique');
            $table->foreign('neighborhood_id')->references('id')->on('ilocations__neighborhoods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ilocations__neighborhood_translations', function (Blueprint $table) {
            $table->dropForeign(['neighborhood_id']);
        });
        Schema::dropIfExists('ilocations__neighborhood_translations');
    }
}
