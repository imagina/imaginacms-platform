<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('iplan__subscriptions', function (Blueprint $table) {
            $table->integer('status')->unsigned()->nullable()->default(1)->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('iplan__subscriptions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
