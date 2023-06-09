<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIappointmentCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iappointment__category_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->text('title');
            $table->string('slug')->index();
            $table->longText('description');

            $table->integer('category_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('iappointment__categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iappointment__category_translations', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('iappointment__category_translations');
    }
}
