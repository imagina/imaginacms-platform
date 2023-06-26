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
        Schema::create('iforms__field_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label')->index();
            $table->string('placeholder');
            $table->string('description');
            $table->integer('field_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['field_id', 'locale']);
            $table->foreign('field_id')->references('id')->on('iforms__fields')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iforms__field_translations', function (Blueprint $table) {
            $table->dropForeign(['field_id']);
        });
        Schema::dropIfExists('iforms__field_translations');
    }
};
