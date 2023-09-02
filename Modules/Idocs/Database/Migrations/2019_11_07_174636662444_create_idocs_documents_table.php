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
        Schema::create('idocs__documents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('user_identification')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('role')->unsigned()->nullable();
            $table->boolean('status')->default(false);
            $table->text('options')->nullable();
            $table->foreign('category_id')->references('id')->on('idocs__categories')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('idocs__documents');
    }
};
