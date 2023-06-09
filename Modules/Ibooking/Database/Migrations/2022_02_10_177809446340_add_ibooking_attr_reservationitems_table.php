<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIbookingAttrReservationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('ibooking__reservation_items', function (Blueprint $table) {
            $table->integer('customer_id')->unsigned()->nullable()->after('end_date');
            $table->foreign('customer_id')->references('id')->on('users');

            $table->string('entity_type')->nullable()->after('end_date');
            $table->integer('entity_id')->unsigned()->nullable()->after('end_date');

            $table->tinyInteger('status')->default(0)->unsigned()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
}
