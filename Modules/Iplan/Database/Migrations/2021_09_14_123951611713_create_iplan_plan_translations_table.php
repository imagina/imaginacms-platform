<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('iplan__plan_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->string('name');
            $table->longText('description');
            $table->bigInteger('plan_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['plan_id', 'locale']);
            $table->foreign('plan_id')->references('id')->on('iplan__plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iplan__plan_translations', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
        });
        Schema::dropIfExists('iplan__plan_translations');
    }
};
