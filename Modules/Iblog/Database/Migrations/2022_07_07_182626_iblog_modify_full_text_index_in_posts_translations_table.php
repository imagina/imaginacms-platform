<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        \DB::statement('ALTER TABLE `iblog__post_translations` DROP INDEX `full`;');
        \DB::statement('ALTER TABLE iblog__post_translations ADD FULLTEXT full(title,description,summary)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
