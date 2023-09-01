<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameInternalColumnToIsInternalInDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            Schema::table('iprofile__departments', function (Blueprint $table) {
                $table->renameColumn('internal', 'is_internal');
            });
        } catch (\Exception $e) {
            \Log::info(" There is no column with name 'is_internal' on table 'iprofile__departments'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iprofile__departments');
    }
}
