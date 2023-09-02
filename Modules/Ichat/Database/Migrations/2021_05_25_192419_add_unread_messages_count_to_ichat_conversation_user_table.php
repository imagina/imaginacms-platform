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
        Schema::table('ichat__conversation_user', function (Blueprint $table) {
            $table->integer('unread_messages_count')->unsigned()->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ichat__conversation_user', function (Blueprint $table) {
            $table->dropColumn(['unread_messages_count']);
        });
    }
};
