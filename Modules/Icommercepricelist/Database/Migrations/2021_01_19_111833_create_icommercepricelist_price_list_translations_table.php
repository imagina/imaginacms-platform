<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommercepricelistPriceListTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommercepricelist__price_list_translations', function (Blueprint $table) {
            $table->increments('id');
            // Your translatable fields
            $table->string('name');

            $table->integer('price_list_id')->unsigned();
            $table->string('locale')->index();
            
            $table->unique(['price_list_id', 'locale'], 'price_list_id_unique');

            $table->foreign('price_list_id','price_list_id_trans')->references('id')->on('icommercepricelist__price_lists')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icommercepricelist__price_list_translations');
    }
}
