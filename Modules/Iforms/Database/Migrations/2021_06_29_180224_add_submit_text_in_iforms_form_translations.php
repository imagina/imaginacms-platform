<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubmitTextInIformsFormTranslations extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('iforms__form_translations', function (Blueprint $table) {
            $table->string('success_text')->nullable()->after('title');
            $table->string('submit_text')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iforms__form_translations', function (Blueprint $table) {
            $table->dropColumn(['submit_text', 'success_text']);
        });
    }
}
