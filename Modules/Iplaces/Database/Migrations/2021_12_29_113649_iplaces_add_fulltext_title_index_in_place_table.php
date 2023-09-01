<?php

use Illuminate\Database\Migrations\Migration;

class IplacesAddFulltextTitleIndexInPlaceTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement('ALTER TABLE iplaces__place_translations ADD FULLTEXT full(title)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
}
