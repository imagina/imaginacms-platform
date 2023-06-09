<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PageChangeUniqueAddingOrganizationInPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page__page_translations', function (Blueprint $table) {
            $table->integer('organization_id')->unsigned()->nullable();

            $table->unique(['slug', 'locale', 'organization_id'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
