<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIcommentsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('icomments__comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            // Your fields...

            $table->string('commenter_id')->nullable();
            $table->string('commenter_type')->nullable();
            $table->index(['commenter_id', 'commenter_type']);

            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();

            $table->morphs('commentable');
            $table->index('commentable_id');
            $table->index('commentable_type');

            $table->text('comment');
            $table->text('options')->nullable();

            $table->boolean('approved')->default(true);
            $table->boolean('internal')->default(false);

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('icomments__comments')->onDelete('cascade');
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

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
        Schema::dropIfExists('icomments__comments');
    }
}
