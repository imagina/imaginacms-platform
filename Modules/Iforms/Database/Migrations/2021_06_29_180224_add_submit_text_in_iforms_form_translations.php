<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iforms__form_translations', function (Blueprint $table) {
            $table->string('success_text')->nullable()->after('title');
            $table->string('submit_text')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iforms__form_translations', function (Blueprint $table) {
            $table->dropColumn(['submit_text', 'success_text']);
        });
    }
};
