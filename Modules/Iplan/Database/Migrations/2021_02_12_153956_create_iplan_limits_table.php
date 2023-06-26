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
        Schema::create('iplan__limits', function (Blueprint $table) {
            $table->id();

            $table->text('name');
            $table->string('entity')->nullable();
            $table->string('attribute')->nullable();
            $table->string('attribute_value')->nullable();
            $table->integer('quantity')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iplan__limits');
    }
};
