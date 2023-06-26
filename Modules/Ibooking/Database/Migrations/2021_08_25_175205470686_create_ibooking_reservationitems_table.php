<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ibooking__reservation_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->integer('reservation_id')->unsigned()->nullable();
            $table->foreign('reservation_id')->references('id')->on('ibooking__reservations');

            $table->integer('service_id')->unsigned()->nullable();
            $table->foreign('service_id')->references('id')->on('ibooking__services');

            $table->integer('resource_id')->unsigned()->nullable();
            $table->foreign('resource_id')->references('id')->on('ibooking__resources');

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('ibooking__categories');

            $table->string('category_title')->nullable();
            $table->string('service_title')->nullable();
            $table->string('resource_title')->nullable();
            $table->float('price', 50, 2)->default(0);

            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibooking__reservation_items');
    }
};
