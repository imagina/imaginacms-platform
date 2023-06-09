<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCategoryRuleIdInAutomationRulesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('requestable__automation_rules', function (Blueprint $table) {
            $table->integer('category_rule_id')->unsigned()->nullable()->after('status_id');
            $table->foreign('category_rule_id')->references('id')->on('requestable__category_rules')->onDelete('restrict');

            $table->tinyInteger('status')->default(1)->unsigned()->after('category_rule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requestable__automation_rules', function (Blueprint $table) {
            $table->dropColumn('category_rule_id');
            $table->dropColumn('status');
        });
    }
}
