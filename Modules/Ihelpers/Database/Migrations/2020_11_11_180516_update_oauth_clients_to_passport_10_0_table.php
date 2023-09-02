<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (! Schema::hasColumn('oauth_clients', 'secret')) {
            Schema::table('oauth_clients', function (Blueprint $table) {
                $table->string('secret', 100)->nullable()->change();
            });
        }

        if (! Schema::hasColumn('oauth_clients', 'provider')) {
            Schema::table('oauth_clients', function (Blueprint $table) {
                $table->string('provider')->after('secret')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
};
