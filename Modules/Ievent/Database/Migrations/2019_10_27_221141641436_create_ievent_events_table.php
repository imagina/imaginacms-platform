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
        Schema::create('ievent__events', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('status')->default(1);

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('ievent__categories')->onDelete('restrict');

            //$table->integer('eventable_id')->unsigned();
            //$table->string('eventable_type');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')
              ->references('id')
              ->on('iprofile__departments')
              ->onDelete('cascade');

            $table->timestamp('date');
            $table->time('hour');
            $table->boolean('is_public');

            $table->text('options')->nullable();
            // Your fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ievent__events');
    }
};
