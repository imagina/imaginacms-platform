<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIappointmentAppointmentStatusTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iappointment__appointment_status_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');

            $table->integer('appointment_status_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['appointment_status_id', 'locale'],'ap_status_locale');
            $table->foreign('appointment_status_id','ap_status_foreign2')->references('id')->on('iappointment__appointment_statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iappointment__appointment_status_translations', function (Blueprint $table) {
            $table->dropForeign('ap_status_foreign2');
        });
        Schema::dropIfExists('iappointment__appointment_status_translations');
    }
}
