<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_shares', function (Blueprint $table) {
            $table->id('share_id');
            $table->unsignedBigInteger('post_id');
            // FIX: Changed unsignedInteger to unsignedBigInteger to match users.user_id
            $table->unsignedBigInteger('user_id'); 
            $table->enum('platform', [
                'facebook',
                'twitter',
                'linkedin',
                'email',
                'copy_link',
                'internal'
            ])->nullable();
            $table->timestamps();
            
            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            
            $table->index(['post_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_shares');
    }
};