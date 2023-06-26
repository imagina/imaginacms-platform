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
        Schema::create('slider__slides', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('slider_id')->unsigned();
            $table->foreign('slider_id')->references('id')->on('slider__sliders')->onDelete('cascade');

            $table->integer('page_id')->unsigned()->nullable();
            $table->integer('position')->unsigned()->default(0);
            $table->string('target', 10)->nullable();
            $table->text('options')->nullable();
            $table->text('external_image_url')->nullable();
            $table->string('type')->default('')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('slider__slides');
    }
};
