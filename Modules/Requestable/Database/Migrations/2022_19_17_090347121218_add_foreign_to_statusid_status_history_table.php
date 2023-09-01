<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignToStatusIdStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('requestable__status_history', function (Blueprint $table) {
            $table->integer('status_id')->unsigned()->change();
            $table->foreign('status_id')->references('id')->on('requestable__statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
}
