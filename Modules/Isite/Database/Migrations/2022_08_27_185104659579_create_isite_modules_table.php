<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIsiteModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isite__modules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->string('alias');
            $table->text('permissions')->nullable();
            $table->text('settings')->nullable();
            $table->text('crud_fields')->nullable();
            $table->text('deprecated_settings')->nullable();
            $table->text('cms_pages')->nullable();
            $table->text('cms_sidebar')->nullable();
            $table->boolean('enabled')->default(false);
            $table->integer('priority')->default(1);
            $table->text('config')->nullable();
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
        Schema::dropIfExists('isite__modules');
    }
}
