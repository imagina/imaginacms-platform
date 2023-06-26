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
        Schema::table('iad__ads', function (Blueprint $table) {
            $table->tinyInteger('checked')->unsigned()->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iad__ads', function (Blueprint $table) {
            $table->dropColumn('checked');
        });
    }
};
