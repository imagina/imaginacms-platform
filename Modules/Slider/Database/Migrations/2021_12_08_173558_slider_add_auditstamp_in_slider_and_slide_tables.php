<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SliderAddAuditstampInSliderAndSlideTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('slider__sliders', function (Blueprint $table) {
        $table->auditStamps();
        $table->unique(['system_name', 'organization_id'])->change();
      });
      Schema::table('slider__slides', function (Blueprint $table) {
        $table->auditStamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
