<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldsNotReqAttrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iforms__field_translations', function (Blueprint $table) {
            $table->string('placeholder')->nullable()->change();
            $table->string('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iforms__field_translations', function (Blueprint $table) {
            $table->string('placeholder')->nullable(false)->change();
            $table->string('description')->nullable(false)->change();
        });
    }
}
