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
        Schema::create('iforms__fields', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type')->index();
            $table->string('name')->nullable();
            $table->boolean('required')->nullable()->default(false);
            $table->string('selectable')->nullable()->default('');
            $table->integer('order')->unsigned()->default(0);
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('iforms__forms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iforms__fields');
    }
};
