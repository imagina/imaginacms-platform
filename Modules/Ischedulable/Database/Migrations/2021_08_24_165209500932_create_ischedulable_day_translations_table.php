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
        Schema::create('ischedulable__day_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('name');

            $table->integer('day_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['day_id', 'locale']);
            $table->foreign('day_id')->references('id')->on('ischedulable__days')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ischedulable__day_translations', function (Blueprint $table) {
            $table->dropForeign(['day_id']);
        });
        Schema::dropIfExists('ischedulable__day_translations');
    }
};
