<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaZonesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('media__zones', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields...
      $table->string("name");
      $table->string("entity_type");
      $table->integer("entity_id")->nullable();
      $table->string("parent_entity_type")->nullable();
      $table->integer("parent_entity_id")->nullable();
      $table->text("options")->nullable();
        
        // Audit fields
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
    Schema::dropIfExists('media__zones');
  }
}
