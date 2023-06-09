<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIeventRecurrenceDaysTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ievent__recurrence_days', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->enum('days', ['1', '2', '3', '4', '5', '6', '7']);
            $table->time('hour');
            $table->integer('recurrence_id')->unsigned();
            $table->foreign('recurrence_id')->references('id')->on('ievent__recurrences')->onDelete('cascade');
            // Your fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ievent__recurrence_days');
    }
}
