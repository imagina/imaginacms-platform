<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteTaxClassIdFromTaxRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__tax_rates', function (Blueprint $table) {
            $table->dropForeign(['tax_class_id']);
            $table->dropColumn('tax_class_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__tax_rates', function (Blueprint $table) {
            if (! Schema::hasColumn('icommerce__tax_rates', 'tax_class_id')) {
                $table->integer('tax_class_id')->unsigned();
            }
        });
    }
}
