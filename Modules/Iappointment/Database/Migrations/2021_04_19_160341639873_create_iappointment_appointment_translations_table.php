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
        Schema::create('iappointment__appointment_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->longText('description');

            $table->integer('appointment_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['appointment_id', 'locale'], 'appointment_id_locale');
            $table->foreign('appointment_id')->references('id')->on('iappointment__appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iappointment__appointment_translations', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
        });
        Schema::dropIfExists('iappointment__appointment_translations');
    }
};
