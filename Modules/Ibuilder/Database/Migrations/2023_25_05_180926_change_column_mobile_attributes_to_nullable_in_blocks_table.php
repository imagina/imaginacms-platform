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
        Schema::table('ibuilder__blocks', function (Blueprint $table) {
            $table->text('mobile_attributes')->nullable()->after('attributes')->change();
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
