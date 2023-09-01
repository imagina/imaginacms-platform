<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInternalColumnInDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('iprofile__departments', function (Blueprint $table) {
            $table->integer('internal')->default(0)->nullable()->after('parent_id');
            $table->integer('parent_id')->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iprofile__departments', function (Blueprint $table) {
            $table->dropColumn('internal');
        });
    }
}
