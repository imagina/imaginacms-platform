<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('iad__ad_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->integer('ad_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['ad_id', 'locale']);
            $table->foreign('ad_id')->references('id')->on('iad__ads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iad__ad_translations', function (Blueprint $table) {
            $table->dropForeign(['ad_id']);
        });
        Schema::dropIfExists('iad__ad_translations');
    }
};
