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
        Schema::create('iplan__plan_limits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('plan_id')->unsigned();
            $table->bigInteger('limit_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('iplan__plans')->onDelete('cascade');
            $table->foreign('limit_id')->references('id')->on('iplan__limits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iplan__plan_limits', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropForeign(['limit_id']);
        });
        Schema::dropIfExists('iplan__plan_limits');
    }
};
