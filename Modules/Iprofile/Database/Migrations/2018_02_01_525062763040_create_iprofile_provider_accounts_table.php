<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIprofileProviderAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iprofile__provider_accounts', function (Blueprint $table) {
            $table->increments('id')->unsigned()->unique();
            $table->string('provider_user_id');
            $table->string('provider');
            $table->integer('user_id')->unsigned()->unique();
            $table->text('options')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iprofile__provider_accounts');
    }
}
