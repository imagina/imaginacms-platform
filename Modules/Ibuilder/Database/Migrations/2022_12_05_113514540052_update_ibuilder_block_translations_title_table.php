<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateIbuilderBlockTranslationsTitleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ibuilder__block_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->renameColumn('title', 'internal_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
}
