<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIplanCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iplan__categories', function (Blueprint $table) {
            $table->id();

            $table->integer('parent_id')->unsigned()->nullable()->default(0);
            $table->string('title');
            $table->longText('description');
            $table->string('slug')->unique();
            $table->longText('options')->nullable();
            $table->integer('status')->unsigned();

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
        Schema::dropIfExists('iplan__categories');
    }
}
