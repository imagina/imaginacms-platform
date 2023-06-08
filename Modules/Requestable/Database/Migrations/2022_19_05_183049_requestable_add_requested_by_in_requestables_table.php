<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RequestableAddRequestedByInRequestablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('requestable__requestables', function (Blueprint $table) {
        $table->integer('requested_by')->unsigned()->nullable()->after("requestable_type");
        $table->foreign('requested_by')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
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
