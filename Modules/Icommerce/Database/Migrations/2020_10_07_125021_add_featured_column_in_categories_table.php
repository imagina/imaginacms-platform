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
        Schema::table('icommerce__categories', function (Blueprint $table) {
            $table->integer('featured')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('icommerce__categories', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__categories', 'featured')) {
                $table->dropColumn('featured');
            }
        });
    }
};
