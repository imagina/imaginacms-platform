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
        Schema::table('isite__organizations', function (Blueprint $table) {
            $table->integer('layout_id')->unsigned()->nullable()->after('data');
            $table->foreign('layout_id')->references('id')->on('isite__layouts')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
