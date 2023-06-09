<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIcommerceCouponOrderHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__coupon_order_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('coupon_id')->unsigned();
            $table->foreign('coupon_id')->references('id')->on('icommerce__coupons')->onDelete('restrict');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('icommerce__orders')->onDelete('restrict');

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

            $table->float('amount', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icommerce__coupon_order_history');
    }
}