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
        Schema::create('notification__providers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name');
            $table->string('system_name');
            $table->boolean('status')->default(false);
            $table->boolean('default')->default(false);
            $table->string('type')->default('');
            $table->text('options')->nullable();
            $table->text('fields')->nullable();
            // Your fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('notification__providers');
    }
};
