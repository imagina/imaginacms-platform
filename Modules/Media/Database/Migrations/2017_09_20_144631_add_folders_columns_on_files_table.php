<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('media__files', function (Blueprint $table) {
            $table->boolean('is_folder')->default(false)->after('id');

            $table->string('path')->nullable()->change();
            $table->string('extension')->nullable()->change();
            $table->string('mimetype')->nullable()->change();
            $table->string('filesize')->nullable()->change();
            $table->string('folder_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media__files', function (Blueprint $table) {
            $table->dropColumn('is_folder');

            $table->string('path')->nullable(false)->change();
            $table->string('extension')->nullable(false)->change();
            $table->string('mimetype')->nullable(false)->change();
            $table->string('filesize')->nullable(false)->change();
            $table->string('folder_id')->nullable(false)->change();
        });
    }
};
