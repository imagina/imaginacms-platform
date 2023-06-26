<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('iblog__posts', function (Blueprint $table) {
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->date('date_available')->nullable();
        });
        Schema::table('iblog__categories', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->unsigned();
            $table->tinyInteger('show_menu')->default(0)->unsigned();
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->integer('parent_id')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iblog__posts', function (Blueprint $table) {
            $table->dropColumn('featured');
            $table->dropColumn('sort_order');
        });
        Schema::table('iblog__categories', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('show_menu');
            $table->dropColumn('featured');
            $table->dropColumn('sort_order');
        });
    }
};
