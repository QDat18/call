<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title', 200)->nullable();
            $table->text('content');
            $table->string('image_url')->nullable();
            $table->enum('post_type', [
                'announcement',
                'success_story',
                'event',
                'impact_update',
                'question',
                'general'
            ])->default('general');
            $table->enum('status', [
                'draft',
                'pending',
                'published',
                'rejected'
            ])->default('published');
            $table->text('admin_notes')->nullable();
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('allow_comments')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->index(['status', 'published_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('is_pinned');
            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
