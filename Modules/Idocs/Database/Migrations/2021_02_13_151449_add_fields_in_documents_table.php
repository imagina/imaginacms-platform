<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
 
  
      Schema::table('idocs__documents', function (Blueprint $table) {
        $table->boolean('private')->default(false);
        $table->integer('downloaded')->default(0);
      });
  
      Schema::table('idocs__document_user', function (Blueprint $table) {
        $table->string('key')->nullable();
        $table->integer('downloaded')->default(0);
    
      });
  
  
      Schema::table('idocs__categories', function (Blueprint $table) {
        $table->integer('parent_id')->nullable()->change();
    
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
