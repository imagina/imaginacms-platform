<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('icommerce__product_discounts', function (Blueprint $table) {
            $table->integer('quantity_sold')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('icommerce__product_discounts', function (Blueprint $table) {
            $table->dropColumn('quantity_sold');
        });
    }
};
