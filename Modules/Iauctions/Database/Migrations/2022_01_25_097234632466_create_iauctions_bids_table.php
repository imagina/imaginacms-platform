<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIauctionsBidsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('iauctions__bids', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->integer('auction_id')->unsigned();
            $table->foreign('auction_id')->references('id')->on('iauctions__auctions')->onDelete('restrict');

            $table->integer('provider_id')->unsigned();
            $table->foreign('provider_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

            $table->text('description');
            $table->double('amount', 30, 2)->default(0);
            $table->double('points', 30, 2)->default(0);
            $table->integer('status')->default(1)->unsigned();

            $table->boolean('winner')->default(false);

            $table->text('options')->nullable();
            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iauctions__bids');
    }
}
