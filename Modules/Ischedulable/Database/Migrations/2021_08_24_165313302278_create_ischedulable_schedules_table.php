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
        Schema::create('ischedulable__schedules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('zone');
            $table->tinyInteger('status')->default(1)->unsigned();
            $table->integer('entity_id');
            $table->string('entity_type');
            $table->timestamp('start_date', 0)->nullable();
            $table->timestamp('end_date', 0)->nullable();

            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ischedulable__schedules');
    }
};
