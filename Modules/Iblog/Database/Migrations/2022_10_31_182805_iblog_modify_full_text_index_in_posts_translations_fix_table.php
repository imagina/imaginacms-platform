<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $indexesFound = array_change_key_case($sm->listTableIndexes('iblog__post_translations'), CASE_LOWER);
        if (! array_key_exists('fulltitle', $indexesFound)) {
            \DB::statement('ALTER TABLE iblog__post_translations ADD FULLTEXT fullTitle(title)');
        }
        if (! array_key_exists('fulltitledescription', $indexesFound)) {
            \DB::statement('ALTER TABLE iblog__post_translations ADD FULLTEXT fullTitleDescription(title,description)');
        }
        if (! array_key_exists('fulltitlesummary', $indexesFound)) {
            \DB::statement('ALTER TABLE iblog__post_translations ADD FULLTEXT fullTitleSummary(title,summary)');
        }
        if (! array_key_exists('fulldescription', $indexesFound)) {
            \DB::statement('ALTER TABLE iblog__post_translations ADD FULLTEXT fullDescription(description)');
        }
        if (! array_key_exists('fulldescriptionsummary', $indexesFound)) {
            \DB::statement('ALTER TABLE iblog__post_translations ADD FULLTEXT fullDescriptionSummary(description,summary)');
        }
        if (! array_key_exists('fullsummary', $indexesFound)) {
            \DB::statement('ALTER TABLE iblog__post_translations ADD FULLTEXT fullSummary(summary)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    //
    }
};
