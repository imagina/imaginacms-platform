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
        Schema::table('requestable__requestables', function (Blueprint $table) {
            $table->integer('requested_by')->unsigned()->nullable()->after('requestable_type');
            $table->foreign('requested_by')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
