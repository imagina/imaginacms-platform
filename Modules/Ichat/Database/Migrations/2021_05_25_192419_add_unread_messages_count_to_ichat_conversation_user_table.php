<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnreadMessagesCountToIchatConversationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ichat__conversation_user', function (Blueprint $table) {
            $table->integer('unread_messages_count')->unsigned()->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ichat__conversation_user', function (Blueprint $table) {
            $table->dropColumn(['unread_messages_count']);
        });
    }
}
