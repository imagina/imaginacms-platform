<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNextPlanIdToSubscriptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('iplan__subscriptions', function (Blueprint $table) {
        $table->bigInteger('next_plan_id')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('iplan__subscriptions', function (Blueprint $table) {
      $table->dropColumn('next_plan_id');
    });
  }
  
}
