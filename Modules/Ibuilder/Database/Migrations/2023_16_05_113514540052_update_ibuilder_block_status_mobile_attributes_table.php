<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateIbuilderBlockStatusMobileAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ibuilder__blocks', function (Blueprint $table) {
            $table->integer('status')->default(1)->after('system_name')->unsigned();
            $table->text('mobile_attributes')->after('attributes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
