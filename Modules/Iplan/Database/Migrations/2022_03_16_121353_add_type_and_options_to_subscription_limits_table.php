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
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->integer('type')->unsigned()->nullable()->after('changed_subscription_date');
            $table->longText('options')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('options');
        });
    }
};
