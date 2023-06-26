<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('iblog__posts', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('iblog__categories')->onDelete('restrict');

            $table->dropForeign('iblog__posts_user_id_foreign');
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iblog__posts', function (Blueprint $table) {
            $table->dropForeign('iblog__posts_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
};
