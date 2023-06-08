<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdocsPrivateField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('idocs__categories', function (Blueprint $table) {
            $table->boolean('private')->default(false);
        });

        Schema::table('idocs__documents', function (Blueprint $table) {
            $table->string('key')->nullable();
            $table->string('email')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
