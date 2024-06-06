<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIlocationsProvinceTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilocations__province_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('name');

            $table->integer('province_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['province_id', 'locale']);
            $table->foreign('province_id')->references('id')->on('ilocations__provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ilocations__province_translations', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
        });
        Schema::dropIfExists('ilocations__province_translations');
    }
}
