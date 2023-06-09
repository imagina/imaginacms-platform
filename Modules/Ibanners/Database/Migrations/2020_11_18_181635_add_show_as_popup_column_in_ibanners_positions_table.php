<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowAsPopupColumnInIbannersPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('ibanners__positions', function (Blueprint $table) {
            $table->boolean('show_as_popup')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('ibanners__positions', function (Blueprint $table) {
            $table->dropColumn('show_as_popup');
        });
    }
}
