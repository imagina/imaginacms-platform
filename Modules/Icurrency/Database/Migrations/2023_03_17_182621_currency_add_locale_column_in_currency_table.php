<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CurrencyAddLocaleColumnInCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icurrency__currencies', function (Blueprint $table) {
        $table->string('locale')->nullable()->after('default_currency');
    
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('icurrency__currencies', function (Blueprint $table) {
        $table->dropColumn('locale');
      });
    
    }
}
