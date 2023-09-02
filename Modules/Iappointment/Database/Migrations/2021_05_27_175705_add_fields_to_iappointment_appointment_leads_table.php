<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('iappointment__appointment_leads', function (Blueprint $table) {
            $table->dropColumn(['values']);
            $table->string('name')->nullable();
            $table->text('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('iappointment__appointment_leads', function (Blueprint $table) {
            $table->dropColumn(['value', 'name']);
            $table->text('values')->nullable();
        });
    }
};
