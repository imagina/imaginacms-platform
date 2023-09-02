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
        Schema::create('requestable__fields', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...

            $table->integer('requestable_id')->unsigned();
            $table->foreign('requestable_id')
              ->references('id')
              ->on('requestable__requestables')
              ->onDelete('cascade');

            $table->string('name')->nullable();
            $table->text('value')->nullable();
            $table->string('type')->nullable();

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
        Schema::dropIfExists('requestable__fields');
    }
};
