<?php

use Illuminate\Database\Migrations\Migration;

class AddFulltextIndiceInPostTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement('ALTER TABLE iblog__post_translations ADD FULLTEXT full(title)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
}
