<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanPlanLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__plan_limits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('plan_id')->unsigned();
            $table->bigInteger('limit_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('iplan__plans')->onDelete('cascade');
            $table->foreign('limit_id')->references('id')->on('iplan__limits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iplan__plan_limits', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropForeign(['limit_id']);
        });
        Schema::dropIfExists('iplan__plan_limits');
    }
}
