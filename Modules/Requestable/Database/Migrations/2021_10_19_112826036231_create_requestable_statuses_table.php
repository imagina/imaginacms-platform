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
        Schema::create('requestable__statuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...

            $table->integer('value')->index();
            $table->text('events')->nullable();
            $table->boolean('final')->default(false);
            $table->boolean('default')->default(false);
            $table->boolean('cancelled_elapsed_time')->default(false);
            $table->boolean('delete_request')->default(false);

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('requestable__categories')->onDelete('cascade');

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
        Schema::dropIfExists('requestable__statuses');
    }
};
