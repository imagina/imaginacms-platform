<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaintenanceModeColumnInOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('isite__organizations', function (Blueprint $table) {
            $table->text('maintenance_mode')->nullable()->after('enable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      //
    }
}
