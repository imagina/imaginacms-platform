<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIsiteRecommendationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('isite__recommendation_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->integer('recommendation_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['recommendation_id', 'locale'], 'unique_recommendation_id');
            $table->foreign('recommendation_id')->references('id')->on('isite__recommendations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('isite__recommendation_translations', function (Blueprint $table) {
            $table->dropForeign(['recommendation_id']);
        });
        Schema::dropIfExists('isite__recommendation_translations');
    }
}
