<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplacesZoneTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplaces__zone_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            // Your translatable fields

            $table->integer('zone_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['zone_id', 'locale']);
            $table->foreign('zone_id')->references('id')->on('iplaces__zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iplaces__zone_translations', function (Blueprint $table) {
            $table->dropForeign(['zone_id']);
        });
        Schema::dropIfExists('iplaces__zone_translations');
    }
}
