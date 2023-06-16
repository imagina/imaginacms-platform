<?php

use Illuminate\Database\Migrations\Migration;

class IplacesAddFulltextTitleIndexInPlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE iplaces__place_translations ADD FULLTEXT full(title)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
