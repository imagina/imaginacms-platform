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
        Schema::create('igamification__activity_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->text('title');
            $table->text('description')->nullable();

            $table->integer('activity_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['activity_id', 'locale']);
            $table->foreign('activity_id')->references('id')->on('igamification__activities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('igamification__activity_translations', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
        });
        Schema::dropIfExists('igamification__activity_translations');
    }
};
