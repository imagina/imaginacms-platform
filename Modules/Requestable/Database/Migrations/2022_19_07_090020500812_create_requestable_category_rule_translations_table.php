<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestableCategoryRuleTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requestable__category_rule_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');

            $table->integer('category_rule_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['category_rule_id', 'locale'],'unique_category_rule_id');
            //$table->unique(['category_rule_id', 'locale']);
            $table->foreign('category_rule_id')->references('id')->on('requestable__category_rules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requestable__category_rule_translations', function (Blueprint $table) {
            $table->dropForeign(['category_rule_id']);
        });
        Schema::dropIfExists('requestable__category_rule_translations');
    }
}
