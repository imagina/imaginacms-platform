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
        Schema::create('iplaces__schedule_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('title');
            // Your translatable fields

            $table->integer('schedule_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['schedule_id', 'locale']);
            $table->foreign('schedule_id')->references('id')->on('iplaces__schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('iplaces__schedule_translations', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
        });
        Schema::dropIfExists('iplaces__schedule_translations');
    }
};
