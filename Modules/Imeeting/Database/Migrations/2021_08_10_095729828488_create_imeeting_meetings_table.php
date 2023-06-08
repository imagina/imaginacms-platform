<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImeetingMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imeeting__meetings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->string('provider_name');
            $table->string('provider_meeting_id');
            $table->text('star_url');
            $table->text('join_url')->nullable();
            $table->string('password')->nullable();

            $table->integer('entity_id');
            $table->string('entity_type');
            
            $table->text('options')->nullable();

            $table->timestamps();
            $table->auditStamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imeeting__meetings');
    }
}
