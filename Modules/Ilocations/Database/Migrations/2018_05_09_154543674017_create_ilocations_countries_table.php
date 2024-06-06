<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIlocationsCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ilocations__countries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->boolean('status')->default('1');
            $table->string('currency');
            $table->text('currency_symbol');
            $table->text('currency_code');
            $table->text('currency_sub_unit');
            
            $table->text('region_code');
            $table->text('sub_region_code');

            $table->integer('country_code')->unsigned();
            $table->text('iso_2',2);
            $table->text('iso_3',3);
            $table->integer('calling_code')->unsigned();

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
        Schema::dropIfExists('ilocations__countries');
    }
}
