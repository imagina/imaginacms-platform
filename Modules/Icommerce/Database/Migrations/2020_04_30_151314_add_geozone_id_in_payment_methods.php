<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeozoneIdInPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
            $table->integer('geozone_id')->unsigned()->nullable();
            $table->foreign('geozone_id')->references('id')->on('ilocations__geozones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__payment_methods', 'geozone_id')) {
                $table->dropForeign('icommerce__payment_methods_geozone_id_foreign');
                $table->dropColumn('geozone_id');
            }
        });
    }
}
