<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id('comment_id');
            $table->unsignedBigInteger('post_id');
            // FIX: Changed unsignedInteger to unsignedBigInteger to match users.user_id
            $table->unsignedBigInteger('user_id'); 
            $table->text('content');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->integer('likes_count')->default(0);
            $table->timestamps();
            
            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('parent_id')->references('comment_id')->on('post_comments')->onDelete('cascade');
            
            $table->index(['post_id', 'created_at']);
            $table->index('user_id');
            $table->index('parent_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
};