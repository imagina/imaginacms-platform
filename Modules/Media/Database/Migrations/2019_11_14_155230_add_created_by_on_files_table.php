<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByOnFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('media__files', function (Blueprint $table) {
        
        $table->integer('created_by')->unsigned()->nullable();
        $table->foreign('created_by')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
  
  
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('media__files', function (Blueprint $table) {
        $table->dropColumn('created_by');
    
      });
    }
}
