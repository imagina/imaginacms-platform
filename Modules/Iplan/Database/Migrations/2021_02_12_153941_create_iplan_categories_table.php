<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
     */
    public function down(): void
    {
        Schema::dropIfExists('iplan__categories');
    }
};
