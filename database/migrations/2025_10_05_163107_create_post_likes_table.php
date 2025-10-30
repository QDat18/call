<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_likes', function (Blueprint $table) {
            $table->id('like_id');
            $table->unsignedBigInteger('post_id');
            // The original file used unsignedInteger, changing to unsignedBigInteger for consistency with users table
            $table->unsignedBigInteger('user_id'); 
            $table->timestamps();

            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->unique(['post_id', 'user_id']);
            $table->index('user_id');
            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_likes');
    }
};