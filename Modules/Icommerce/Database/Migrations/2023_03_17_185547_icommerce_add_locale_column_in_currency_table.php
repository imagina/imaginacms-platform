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
        Schema::table('icommerce__currencies', function (Blueprint $table) {
            $table->string('locale')->nullable()->after('default_currency');
            $table->string('decimal_separator')->default('.')->after('default_currency');
            $table->string('thousands_separator')->default(',')->after('default_currency');
            $table->renameColumn('decimal_place', 'decimals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('icommerce__currencies', function (Blueprint $table) {
            $table->dropColumn('locale');
            $table->dropColumn('decimal_separator');
            $table->dropColumn('thousands_separator');
        });
    }
};
