<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIappointmentAppointmentStatusHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iappointment__appointment_status_histories', function (Blueprint $table) {
            $table->id();

            $table->integer('appointment_id')->unsigned();
            $table->foreign('appointment_id', 'appointment_id_foreign')->references('id')->on('iappointment__appointments')->onDelete('restrict');

            $table->integer('status_id')->default(1)->unsigned();
            $table->foreign('status_id', 'status_id_foreign_3')->references('id')->on('iappointment__appointment_statuses')->onDelete('restrict');

            $table->integer('assigned_to')->unsigned()->nullable();
            $table->foreign('assigned_to', 'assigned_to_foreign')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

            $table->tinyInteger('notify')->default(1)->unsigned();
            $table->longText('comment')->nullable();

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
        Schema::table('iappointment__appointment_status_histories', function (Blueprint $table) {
            $table->dropForeign('appointment_id_foreign');
            $table->dropForeign('status_id_foreign_3');
            $table->dropForeign('assigned_to_foreign');
        });
        Schema::dropIfExists('iappointment__appointment_status_histories');
    }
}
