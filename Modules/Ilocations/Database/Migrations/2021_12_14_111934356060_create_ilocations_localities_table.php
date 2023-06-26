<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ilocations__localities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->text('code', 6);

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('ilocations__countries')->onDelete('cascade');

            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('ilocations__provinces')->onDelete('cascade');

            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('ilocations__cities')->onDelete('cascade');

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
    public function down(): void
    {
        Schema::dropIfExists('ilocations__localities');
    }
};
