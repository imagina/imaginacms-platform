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
        Schema::create('iappointment__appointments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id', 'ap_category_foreign')->references('id')->on('iappointment__categories')->onDelete('restrict');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id', 'ap_status_foreign')->references('id')->on('iappointment__appointment_statuses')->onDelete('restrict');

            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

            $table->integer('assigned_to')->unsigned()->nullable();
            $table->foreign('assigned_to')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

            $table->text('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('iappointment__appointments', function (Blueprint $table) {
            $table->dropForeign('ap_category_foreign');
            $table->dropForeign('ap_status_foreign');
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['assigned_to']);
        });
        Schema::dropIfExists('iappointment__appointments');
    }
};
