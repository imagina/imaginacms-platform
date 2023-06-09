<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIcommerceTaxClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('icommerce__tax_classes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->timestamps();
        });

        Schema::table('icommerce__tax_rates', function (Blueprint $table) {
            $table->foreign('tax_class_id')->references('id')->on('icommerce__tax_classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('icommerce__tax_rates', function (Blueprint $table) {
            //$table->dropForeign(['tax_class_id']);
        });

        Schema::dropIfExists('icommerce__tax_classes');
    }
}
