<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ifollow__followers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->integer('follower_id')->unsigned();
            $table->foreign('follower_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
            $table->integer('followable_id')->unsigned();
            $table->string('followable_type');
            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ifollow__followers');
    }
};
