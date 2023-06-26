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
        Schema::table('iplan__plans', function (Blueprint $table) {
            $table->integer('sort_order')->after('category_id')->default(0);
            $table->integer('status')->after('category_id')->default(1);
            $table->text('options')->modifyAfter('category_id')->change();
            $table->boolean('internal')->default(false)->after('category_id');

            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iplan__plans', function (Blueprint $table) {
            $table->dropColumn('sort_order');
            $table->dropColumn('status');
            $table->dropColumn('internal');
        });
    }
};
