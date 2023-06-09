<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IcommerceAddColumnShowPriceIsCallInProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->boolean('show_price_is_call')->default(false)->after('entity_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->dropColumn('show_price_is_call');
        });
    }
}
