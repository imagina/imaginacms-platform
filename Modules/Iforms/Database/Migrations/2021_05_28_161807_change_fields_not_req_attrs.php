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
    public function up(): void
    {
        Schema::table('iforms__field_translations', function (Blueprint $table) {
            $table->string('placeholder')->nullable()->change();
            $table->string('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('iforms__field_translations', function (Blueprint $table) {
            $table->string('placeholder')->nullable(false)->change();
            $table->string('description')->nullable(false)->change();
        });
    }
};
