<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplacesPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplaces__places', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            // fields
            $table->text('options')->nullable();
            $table->text('schedules')->nullable();
            $table->integer('city_id')->default(0)->unsigned();
            $table->integer('province_id')->default(0)->unsigned();
            $table->integer('status')->default(0)->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('zone_id')->unsigned()->nullable();
            $table->integer('service_id')->unsigned()->nullable();
            $table->integer('schedule_id')->unsigned()->nullable();
            $table->text('address')->nullable()->nullable();
            $table->integer('range_id')->unsigned()->nullable();
            $table->integer('gama')->default(0)->unsigned()->nullable();
            $table->integer('quantity_person')->default(0)->unsigned()->nullable();
            $table->integer('weather')->default(0)->unsigned();
            $table->integer('housing')->default(0)->unsigned();
            $table->integer('transport')->default(0)->unsigned();

            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
            // Your fields
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
        Schema::table('iplaces__places', function (Blueprint $table) {
           // $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('iplaces__places');
    }
}
