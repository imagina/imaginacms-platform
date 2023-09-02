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
        Schema::create('notification__template_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('name');

            $table->integer('template_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['template_id', 'locale']);
            $table->foreign('template_id')->references('id')->on('notification__templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('notification__template_translations', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
        });
        Schema::dropIfExists('notification__template_translations');
    }
};
