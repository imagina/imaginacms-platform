<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishlistableWishlistablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishlistable__wishlistables', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
  
          $table->string('wishlistable_type');
          $table->integer('wishlistable_id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('cascade');
  
          $table->index(['wishlistable_type', 'wishlistable_id', 'user_id'], 'wishlistable_type_id_foreign');

          
          // Your fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishlistable__wishlistables');
    }
}
