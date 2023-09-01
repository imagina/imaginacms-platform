<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIsiteLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('isite__layouts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->string('system_name', 255);
            $table->string('module_name', 255);
            $table->string('entity_name', 255);
            $table->string('entity_type', 255)->nullable();
            $table->string('path', 255);
            $table->integer('status')->default(1);
            $table->string('record_type')->index()->nullable();

            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('isite__layouts');
    }
}
