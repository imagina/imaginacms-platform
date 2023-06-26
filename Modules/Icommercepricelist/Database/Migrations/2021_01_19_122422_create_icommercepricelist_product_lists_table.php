<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('icommercepricelist__product_lists', function (Blueprint $table) {
            $table->increments('id');
            // Your fields
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id', 'product_list_product_foreign')->references('id')->on('icommerce__products')->onDelete('restrict');

            $table->integer('price_list_id')->unsigned();
            $table->foreign('price_list_id', 'product_price_list_foreign')->references('id')->on('icommercepricelist__price_lists')->onDelete('restrict');

            $table->decimal('price', 20, 2);

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
        Schema::dropIfExists('icommercepricelist__product_lists');
    }
};
