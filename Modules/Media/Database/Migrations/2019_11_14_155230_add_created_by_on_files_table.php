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
        Schema::table('media__files', function (Blueprint $table) {
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media__files', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
};
