<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIgamificationActivityCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('igamification__activity_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            
            // Your fields...
            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('igamification__activities')->onDelete('cascade');
  
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('igamification__categories')->onDelete('cascade');
            
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
        Schema::dropIfExists('igamification__activity_category');
    }
}
