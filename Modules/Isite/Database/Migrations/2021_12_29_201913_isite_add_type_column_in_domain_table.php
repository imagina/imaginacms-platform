<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsiteAddTypeColumnInDomainTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('isite__domains', function (Blueprint $table) {
            // Your fields...
            $table->string('type')->default('default')->after('domain');
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
