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
        Schema::create('iplaces__space_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('meta_title');
            $table->text('meta_keywords');
            $table->text('meta_description');

            $table->text('options')->nullable();

            $table->integer('space_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['space_id', 'locale']);
            $table->foreign('space_id')->references('id')->on('iplaces__spaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iplaces__space_translations', function (Blueprint $table) {
            $table->dropForeign(['space_id']);
        });
        Schema::dropIfExists('iplaces__space_translations');
    }
};
