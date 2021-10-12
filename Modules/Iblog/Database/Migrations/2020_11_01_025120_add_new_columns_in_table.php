<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iblog__posts', function (Blueprint $table) {
					$table->boolean('featured')->default(false);
          $table->integer('sort_order')->default(0);
          $table->date('date_available')->nullable();
        });
      Schema::table('iblog__categories', function (Blueprint $table) {
        $table->tinyInteger('status')->default(1)->unsigned();
        $table->tinyInteger('show_menu')->default(0)->unsigned();
        $table->boolean('featured')->default(false);
        $table->integer('sort_order')->default(0);
        $table->integer('parent_id')->nullable()->default(null)->change();
  
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iblog__posts', function (Blueprint $table) {
					$table->dropColumn('featured');
          $table->dropColumn('sort_order');
        });
      Schema::table('iblog__categories', function (Blueprint $table) {
        $table->dropColumn('status');
        $table->dropColumn('show_menu');
        $table->dropColumn('featured');
        $table->dropColumn('sort_order');
      });
    }
}
