<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfillableFieldsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ifillable__fields', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields...
      $table->string('name')->nullable();
      $table->string('type')->nullable();
      $table->integer('entity_id');
      $table->string('entity_type');
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
    Schema::dropIfExists('ifillable__fields');
  }
}
