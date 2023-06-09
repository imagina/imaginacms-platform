<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuscriptionIdAndSuscriptionTokenInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__orders', function (Blueprint $table) {
            $table->string('suscription_id')->nullable();
            $table->text('suscription_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__orders', function (Blueprint $table) {
            $table->dropColumn('suscription_id');
            $table->dropColumn('suscription_token');
        });
    }
}