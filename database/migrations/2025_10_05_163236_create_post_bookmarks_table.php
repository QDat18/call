<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_bookmarks', function (Blueprint $table) {
            $table->id('bookmark_id');
            $table->unsignedBigInteger('post_id');
            // FIX: Changed unsignedInteger to unsignedBigInteger to match users.user_id
            $table->unsignedBigInteger('user_id'); 
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            
            $table->unique(['post_id', 'user_id']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_bookmarks');
    }
};