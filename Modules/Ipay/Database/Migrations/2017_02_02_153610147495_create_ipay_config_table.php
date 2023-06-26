<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ipay__config', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // fields
            $table->boolean('status')->nullable();

            $table->string('title', 255);

            $table->integer('merchantid');

            $table->integer('accountid');

            $table->string('apikey', 255);

            $table->string('currency', 10);

            $table->boolean('mode')->nullable();

            $table->string('replyurl', 255);

            $table->string('confirmationurl', 255);

            $table->text('options')->nullable();

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
        Schema::dropIfExists('ipay__config');
    }
};
