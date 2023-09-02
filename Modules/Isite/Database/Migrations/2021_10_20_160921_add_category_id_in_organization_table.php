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
        Schema::table('isite__organizations', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->nullable()->after('data');
            $table->foreign('category_id')->references('id')->on('isite__categories')->onDelete('restrict');
        });
        Schema::table('isite__organization_translations', function (Blueprint $table) {
            $table->unique(['title']);
            $table->unique(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
};
