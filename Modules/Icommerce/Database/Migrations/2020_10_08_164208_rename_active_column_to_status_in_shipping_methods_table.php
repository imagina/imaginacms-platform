<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            Schema::table('icommerce__shipping_methods', function (Blueprint $table) {
                $table->renameColumn('active', 'status');
            });
        } catch(\Exception $e) {
            \Log::info(" There is no column with name 'status' on table 'icommerce__shipping_methods'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
