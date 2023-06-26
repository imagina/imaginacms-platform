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
        Schema::table('menu__menuitem_translations', function (Blueprint $table) {
            $table->string('description')->after('uri')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('menu__menuitem_translations', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
