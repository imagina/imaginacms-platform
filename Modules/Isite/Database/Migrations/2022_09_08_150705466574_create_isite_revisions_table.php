<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIsiteRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isite__revisions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('revisionable_type');
            $table->unsignedBigInteger('revisionable_id');
            $table->string('key');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamps();
            $table->auditStamps();

            $table->index(['revisionable_id', 'revisionable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('isite__revisions');
    }
}
