<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndOptionsToSubscriptionLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->integer('type')->unsigned()->nullable()->after('changed_subscription_date');
            $table->longText('options')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('options');
        });
    }
}