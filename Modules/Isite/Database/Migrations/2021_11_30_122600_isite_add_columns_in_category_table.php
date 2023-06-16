<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('isite__categories', function (Blueprint $table) {
            $table->tinyInteger('show_menu')->after('options')->default(0)->unsigned();
            $table->integer('featured')->after('options')->default(0);
            $table->integer('sort_order')->after('options')->default(0);
            $table->tinyInteger('status')->after('options')->default(1)->unsigned();
            $table->string('external_id')->after('options')->nullable();
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
};
