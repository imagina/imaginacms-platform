<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IblogAddExternalIdInCategoryAndPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('iblog__categories', function (Blueprint $table) {
        $table->string("external_id")->nullable()->after("options");
      });
      Schema::table('iblog__posts', function (Blueprint $table) {
        $table->string("external_id")->nullable()->after("user_id");
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
