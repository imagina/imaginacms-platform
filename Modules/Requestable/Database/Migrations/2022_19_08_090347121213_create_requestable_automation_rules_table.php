<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestableAutomationRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requestable__automation_rules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields...
            $table->string('name');
            $table->string('run_type'); //values = (currentTime, exactTime, inAfter, inBefore)

            $table->text('run_config')->nullable(); //values = {value: int, type: days | minutes | hours, date: datetime}
            $table->boolean('working_hours')->default(false);

            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('requestable__statuses')->onDelete('restrict');

            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requestable__automation_rules');
    }
}
