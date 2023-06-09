<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IadAdNeighborhoodIdInTheAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('iad__ads', function (Blueprint $table) {
            $table->integer('neighborhood_id')->unsigned()->nullable()->after('options');
            $table->foreign('neighborhood_id')->references('id')->on('ilocations__neighborhoods')->onDelete('restrict');
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
