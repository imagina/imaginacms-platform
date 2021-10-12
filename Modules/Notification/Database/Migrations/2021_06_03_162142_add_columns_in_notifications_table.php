<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification__notifications', function (Blueprint $table) {
          $table->text('options')->after('is_read')->nullable();
          $table->boolean('is_action')->after('is_read')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification__notifications', function (Blueprint $table) {
          $table->dropColumn('options');
          $table->dropColumn('is_action');
        });
    }
}
