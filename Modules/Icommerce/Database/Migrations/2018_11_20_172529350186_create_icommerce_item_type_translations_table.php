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
        Schema::create('icommerce__item_type_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->text('title');
            $table->integer('item_type_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['item_type_id', 'locale']);
            $table->foreign('item_type_id')->references('id')->on('icommerce__item_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__item_type_translations', function (Blueprint $table) {
            $table->dropForeign(['item_type_id']);
        });
        Schema::dropIfExists('icommerce__item_type_translations');
    }
};
