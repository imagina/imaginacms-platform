<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAddAuditstampInAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
  
      Schema::table('roles', function (Blueprint $table) {
      //  $table->dropUnique('slug');
        $table->auditStamps();
        $table->unique(['slug', 'organization_id']);
      });
  
      Schema::table('users', function (Blueprint $table) {
      //  $table->dropUnique('email');
        $table->auditStamps();
        $table->unique(['email', 'organization_id']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
