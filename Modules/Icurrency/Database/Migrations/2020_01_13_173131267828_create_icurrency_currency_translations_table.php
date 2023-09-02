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
        Schema::create('icurrency__currency_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('name');
            $table->integer('currency_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['currency_id', 'locale']);
            $table->foreign('currency_id')->references('id')->on('icurrency__currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icurrency__currency_translations', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
        });
        Schema::dropIfExists('icurrency__currency_translations');
    }
};
