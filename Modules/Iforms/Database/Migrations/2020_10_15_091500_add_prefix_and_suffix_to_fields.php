<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrefixAndSuffixToFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->string('suffix')->nullable()->after('order');
            $table->string('prefix')->nullable()->after('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iforms__fields', function (Blueprint $table) {
            $table->dropColumn('prefix');
            $table->dropColumn('suffix');
        });
    }
}
