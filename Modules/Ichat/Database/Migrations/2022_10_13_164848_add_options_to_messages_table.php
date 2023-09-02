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
        Schema::table('ichat__messages', function (Blueprint $table) {
            $table->text('options')->nullable()->after('reply_to_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ichat__messages', function (Blueprint $table) {
            $table->dropColumn('options');
        });
    }
};
