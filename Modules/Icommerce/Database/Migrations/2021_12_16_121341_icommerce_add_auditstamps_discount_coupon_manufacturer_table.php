<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IcommerceAddAuditstampsDiscountCouponManufacturerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('icommerce__product_discounts', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('icommerce__coupons', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('icommerce__manufacturers', function (Blueprint $table) {
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
}
