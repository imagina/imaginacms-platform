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
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->boolean('show_price_is_call')->default(false)->after('entity_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->dropColumn('show_price_is_call');
        });
    }
};
