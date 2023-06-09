<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlockIdAndFormType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->integer('block_id')->unsigned()->nullable();
            $table->foreign('block_id')->references('id')->on('iforms__blocks')->onDelete('cascade');
        });

        Schema::table('iforms__forms', function (Blueprint $table) {
            $table->integer('form_type')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iforms__forms', function (Blueprint $table) {
            $table->dropColumn('form_type');
        });

        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->dropForeign(['block_id']);
            $table->dropColumn('block_id');
        });
    }
}
