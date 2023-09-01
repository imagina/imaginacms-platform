<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIbookingServicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ibooking__services', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->float('price', 50, 2)->default(0);
            $table->tinyInteger('status')->default(1)->unsigned();
            $table->tinyInteger('with_meeting')->default(0)->unsigned();
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('ibooking__categories')->onDelete('restrict');
            $table->integer('shift_time')->default(30)->nullable();
            $table->text('options')->nullable();

            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibooking__services');
    }
}
