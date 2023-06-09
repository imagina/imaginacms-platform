<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTranslationTranslationsTableWithIndex extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('translation__translations', function (Blueprint $table) {
            $table->index('key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('translation__translations', function (Blueprint $table) {
            $table->dropIndex('translation__translations_key_index');
        });
    }
}
