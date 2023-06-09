<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusInCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__categories', function (Blueprint $table) {
            $table->tinyInteger('status')->default(1)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__categories', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__categories', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
