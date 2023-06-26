<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ifeed__feed_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('feed_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['feed_id', 'locale']);
            $table->foreign('feed_id')->references('id')->on('ifeed__feeds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ifeed__feed_translations', function (Blueprint $table) {
            $table->dropForeign(['feed_id']);
        });
        Schema::dropIfExists('ifeed__feed_translations');
    }
};
