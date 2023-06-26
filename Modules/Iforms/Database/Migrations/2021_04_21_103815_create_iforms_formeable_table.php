<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('iforms__formeable', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('form_id')->unsigned();
            $table->integer('formeable_id')->unsigned();
            $table->string('formeable_type');
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
        Schema::dropIfExists('iforms__formeable');
    }
};
