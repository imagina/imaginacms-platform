<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('icommerce__product_option', function (Blueprint $table) {
            $table->integer('sort_order')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('icommerce__product_option', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
