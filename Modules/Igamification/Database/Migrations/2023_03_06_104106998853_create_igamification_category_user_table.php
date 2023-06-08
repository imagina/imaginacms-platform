<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIgamificationCategoryUserTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('igamification__category_user', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');

      // Your fields...
      $table->integer('category_id')->unsigned();
      $table->foreign('category_id')->references('id')->on('igamification__categories')->onDelete('cascade');

      $table->integer('user_id')->unsigned();
      $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('cascade');

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
    Schema::dropIfExists('igamification__activity_user');
  }
}
