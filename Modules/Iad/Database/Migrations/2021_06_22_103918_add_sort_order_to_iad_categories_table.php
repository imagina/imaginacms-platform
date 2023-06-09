<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortOrderToIadCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('iad__categories', function (Blueprint $table) {
            $table->integer('sort_order')->unsigned()->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iad__categories', function (Blueprint $table) {
            $table->dropColumn(['sort_order']);
        });
    }
}
