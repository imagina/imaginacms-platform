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
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
            $table->tinyInteger('payout')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__payment_methods', 'payout')) {
                $table->dropColumn('payout');
            }
        });
    }
};
