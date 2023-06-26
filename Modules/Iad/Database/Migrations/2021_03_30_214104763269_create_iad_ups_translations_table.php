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
    public function up(): void
    {
        Schema::create('iad__ups_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->string('title');
            $table->text('description');
            $table->integer('up_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['up_id', 'locale']);
            $table->foreign('up_id')->references('id')->on('iad__ups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('iad__ups_translations', function (Blueprint $table) {
            $table->dropForeign(['ups_id']);
        });
        Schema::dropIfExists('iad__ups_translations');
    }
};
