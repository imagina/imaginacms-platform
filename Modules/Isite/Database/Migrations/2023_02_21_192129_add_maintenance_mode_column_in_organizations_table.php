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
        Schema::table('isite__organizations', function (Blueprint $table) {
            $table->text('maintenance_mode')->nullable()->after('enable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
      //
    }
};
