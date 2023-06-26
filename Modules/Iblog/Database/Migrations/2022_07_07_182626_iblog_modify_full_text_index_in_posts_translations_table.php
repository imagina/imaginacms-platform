<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement('ALTER TABLE `iblog__post_translations` DROP INDEX `full`;');
        \DB::statement('ALTER TABLE iblog__post_translations ADD FULLTEXT full(title,description,summary)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
