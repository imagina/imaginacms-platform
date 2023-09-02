<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ibanners__banner_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('banner_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('code_ads')->nullable();
            $table->string('url')->nullable();
            $table->string('uri')->nullable();
            $table->text('custom_html')->nullable();
            $table->boolean('active')->default(false);

            $table->unique(['banner_id', 'locale']);
            $table->foreign('banner_id')->references('id')->on('ibanners__banners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('slider__slide_translations');
    }
};
