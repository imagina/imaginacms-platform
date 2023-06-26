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
        Schema::create('ilocations__locality_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('name');

            $table->integer('locality_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['locality_id', 'locale']);
            $table->foreign('locality_id')->references('id')->on('ilocations__localities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('ilocations__locality_translations', function (Blueprint $table) {
            $table->dropForeign(['locality_id']);
        });
        Schema::dropIfExists('ilocations__locality_translations');
    }
};
