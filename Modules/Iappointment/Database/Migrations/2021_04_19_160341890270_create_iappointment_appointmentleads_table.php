<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIappointmentAppointmentLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iappointment__appointment_leads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->integer('appointment_id')->unsigned();
            $table->foreign('appointment_id')->references('id')->on('iappointment__appointments')->onDelete('restrict');

            $table->longText('values')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iappointment__appointment_leads', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
        });
        Schema::dropIfExists('iappointment__appointment_leads');
    }
}
