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
        Schema::create('iplan__subscriptions', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->longText('description');
            $table->string('category_name');
            $table->string('entity')->nullable();
            $table->string('entity_id')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iplan__subscriptions');
    }
};
