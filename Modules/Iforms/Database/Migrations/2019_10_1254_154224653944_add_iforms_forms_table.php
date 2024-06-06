<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIformsFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iforms__forms', function (Blueprint $table) {
            $table->string('system_name', 40);
            $table->boolean('active')->default(false);
            $table->text('destination_email')->nullable();
        });
    }

}
