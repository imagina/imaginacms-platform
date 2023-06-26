<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('icommercepricelist__price_list_translations', function (Blueprint $table) {
            $table->increments('id');
            // Your translatable fields
            $table->string('name');

            $table->integer('price_list_id')->unsigned();
            $table->string('locale')->index();

            $table->unique(['price_list_id', 'locale'], 'price_list_id_unique');

            $table->foreign('price_list_id', 'price_list_id_trans')->references('id')->on('icommercepricelist__price_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('icommercepricelist__price_list_translations');
    }
};
