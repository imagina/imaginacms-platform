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
        Schema::create('isite__module_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('name');

            $table->integer('module_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['module_id', 'locale']);
            $table->foreign('module_id')->references('id')->on('isite__modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('isite__module_translations', function (Blueprint $table) {
            $table->dropForeign(['module_id']);
        });
        Schema::dropIfExists('isite__module_translations');
    }
};
