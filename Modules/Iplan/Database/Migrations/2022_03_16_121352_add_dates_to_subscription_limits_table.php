<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->dateTime('start_date')->nullable()->after('quantity_used');
            $table->dateTime('end_date')->nullable()->after('start_date');
            $table->dateTime('changed_subscription_date')->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('iplan__subscription_limits', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('changed_subscription_date');
        });
    }
};
