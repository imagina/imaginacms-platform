<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iforms__block_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->integer('block_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['block_id', 'locale']);
            $table->foreign('block_id')->references('id')->on('iforms__blocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iforms__block_translations', function (Blueprint $table) {
            $table->dropForeign(['block_id']);
        });
        Schema::dropIfExists('iforms__block_translations');
    }
};
