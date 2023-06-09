<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductDiscountIdInOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('icommerce__order_item', function (Blueprint $table) {
            $table->integer('product_discount_id')->unsigned()->nullable();
            $table->foreign('product_discount_id')->references('id')->on('icommerce__product_discounts')->onDelete('cascade');

            $table->text('discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('icommerce__order_item', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__order_item', 'product_discount_id')) {
                //$table->dropForeign(['product_discount_id']);
                $table->dropColumn('product_discount_id');
            }
            if (Schema::hasColumn('icommerce__order_item', 'discount')) {
                $table->dropColumn('discount');
            }
        });
    }
}
