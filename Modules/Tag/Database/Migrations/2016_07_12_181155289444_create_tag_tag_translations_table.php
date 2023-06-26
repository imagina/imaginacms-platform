<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tag__tag_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('slug');
            $table->string('name');

            $table->integer('tag_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['tag_id', 'locale']);
            $table->foreign('tag_id')->references('id')->on('tag__tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('tag__tag_translations');
    }
};
