<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('icommerce__tax_class_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your translatable fields
            $table->string('name');
            $table->string('description');

            $table->integer('tax_class_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['tax_class_id', 'locale']);
            $table->foreign('tax_class_id')->references('id')->on('icommerce__tax_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('icommerce__tax_class_translations', function (Blueprint $table) {
            $table->dropForeign(['tax_class_id']);
        });
        Schema::dropIfExists('icommerce__tax_class_translations');
    }
};
