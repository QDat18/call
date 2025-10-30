<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tags table
        Schema::create('tags', function (Blueprint $table) {
            $table->id('tag_id');
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique();
            $table->text('description')->nullable();
            $table->integer('posts_count')->default(0);
            $table->timestamps();
            
            $table->index('slug');
        });

        // Post-Tag pivot table
        Schema::create('post_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();
            
            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
            $table->foreign('tag_id')->references('tag_id')->on('tags')->onDelete('cascade');
            
            $table->primary(['post_id', 'tag_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('tags');
    }
};