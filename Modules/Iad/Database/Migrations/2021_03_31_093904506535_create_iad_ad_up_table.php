<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIadAdUpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('iad__ad_up', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('ad_id')->unsigned();

            $table->integer('up_id')->unsigned();

            $table->integer('order_id')->unsigned();

            $table->boolean('status')->default(0)->unsigned();

            $table->integer('days_limit');
            $table->integer('ups_daily');

            $table->integer('days_counter')->default(0);
            $table->integer('ups_counter')->default(0);

            $table->date('from_date');
            $table->date('to_date');

            $table->time('from_hour');
            $table->time('to_hour');

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
        Schema::dropIfExists('iad__ad_up');
    }
}
