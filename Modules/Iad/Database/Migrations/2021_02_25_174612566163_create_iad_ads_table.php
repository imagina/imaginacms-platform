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
        Schema::create('iad__ads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
            $table->integer('status')->default(0)->unsigned();
            $table->double('min_price', 30, 2)->default(0);
            $table->double('max_price', 30, 2)->default(0);
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('ilocations__countries')->onDelete('restrict');
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('ilocations__provinces')->onDelete('restrict');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('ilocations__cities')->onDelete('restrict');
            $table->integer('featured')->default(0)->unsigned()->nullable();
            $table->timestamp('uploaded_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->text('options')->nullable();
            // Your fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('iad__ads');
    }
};
