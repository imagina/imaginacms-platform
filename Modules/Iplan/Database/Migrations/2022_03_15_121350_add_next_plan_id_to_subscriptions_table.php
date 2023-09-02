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
        Schema::table('iplan__subscriptions', function (Blueprint $table) {
            $table->bigInteger('next_plan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iplan__subscriptions', function (Blueprint $table) {
            $table->dropColumn('next_plan_id');
        });
    }
};
