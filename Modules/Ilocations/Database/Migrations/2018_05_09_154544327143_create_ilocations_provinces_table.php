<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIlocationsProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilocations__provinces', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            
            $table->text('iso_2',5);

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('ilocations__countries')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('ilocations__provinces', function (Blueprint $table) {
        $table->dropForeign([
          'country_id',
        ]);
      });
        Schema::dropIfExists('ilocations__provinces');
    }
}
