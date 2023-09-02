<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        \DB::statement('ALTER TABLE iplaces__place_translations ADD FULLTEXT full(title)');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
};
