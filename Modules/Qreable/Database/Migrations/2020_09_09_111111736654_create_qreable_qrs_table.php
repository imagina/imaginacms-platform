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
    public function up()
    {
        Schema::create('qreable__qrs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->longText('code')->nullable();
            $table->timestamps();
        });

        Schema::create('qreable__qred', function (Blueprint $table) {
            $table->increments('id');
            $table->string('qreable_type');
            $table->integer('qreable_id')->unsigned();
            $table->integer('qr_id')->unsigned();
            $table->index(['qreable_type', 'qreable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qreable__qrs');
        Schema::dropIfExists('qreable__qred');
    }
};
