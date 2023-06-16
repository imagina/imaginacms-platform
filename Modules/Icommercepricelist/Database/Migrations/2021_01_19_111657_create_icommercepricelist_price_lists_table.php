<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommercepricelist__price_lists', function (Blueprint $table) {
            $table->increments('id');
            // Your fields
            $table->integer('status')->default(1);
            $table->enum('criteria', ['percentage', 'fixed'])->default('fixed');
            $table->enum('operation_prefix', ['+', '-'])->default('-');
            $table->float('value', 8, 2)->default(0);
            $table->integer('related_id')->nullable();
            $table->string('related_entity')->nullable();

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
        Schema::dropIfExists('icommercepricelist__price_lists');
    }
};
