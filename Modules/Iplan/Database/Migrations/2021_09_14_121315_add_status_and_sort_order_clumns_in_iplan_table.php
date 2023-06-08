<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAndSortOrderClumnsInIplanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iplan__plans', function (Blueprint $table) {
          $table->integer('sort_order')->after("category_id")->default(0);
          $table->integer('status')->after("category_id")->default(1);
          $table->text('options')->modifyAfter("category_id")->change();
          $table->boolean('internal')->default(false)->after('category_id');
  
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
        Schema::table('iplan__plans', function (Blueprint $table) {
          $table->dropColumn('sort_order');
          $table->dropColumn('status');
          $table->dropColumn('internal');
        });
    }
}
