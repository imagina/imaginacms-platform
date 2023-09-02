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
        Schema::create('iauctions__auction_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->text('title');
            $table->text('description');

            $table->integer('auction_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['auction_id', 'locale']);
            $table->foreign('auction_id')->references('id')->on('iauctions__auctions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iauctions__auction_translations', function (Blueprint $table) {
            $table->dropForeign(['auction_id']);
        });
        Schema::dropIfExists('iauctions__auction_translations');
    }
};
