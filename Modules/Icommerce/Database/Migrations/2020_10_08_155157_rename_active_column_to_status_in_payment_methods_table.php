<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        try {
            Schema::table('icommerce__payment_methods', function (Blueprint $table) {
                $table->renameColumn('active', 'status');
            });
        } catch(\Exception $e) {
            \Log::info(" There is no column with name 'status' on table 'icommerce__payment_methods'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
