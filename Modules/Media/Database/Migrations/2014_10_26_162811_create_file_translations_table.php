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
        Schema::create(
            'media__file_translations',
            function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('file_id')->unsigned();
                $table->string('locale')->index();
                $table->string('description')->nullable();
                $table->string('alt_attribute')->nullable();
                $table->string('keywords')->nullable();
                $table->unique(['file_id', 'locale']);
                $table->foreign('file_id')->references('id')->on('media__files')->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('media__file_translations');
    }
};
