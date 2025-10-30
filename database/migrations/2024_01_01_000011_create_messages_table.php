<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('message_id');

            $table->unsignedBigInteger('conversation_id');
            $table->foreign('conversation_id')
                ->references('conversation_id')
                ->on('conversations')
                ->onDelete('cascade');

            $table->unsignedBigInteger('sender_id');
            $table->foreign('sender_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');

            $table->enum('message_type', [
                'text', 'image', 'file', 'video', 'opportunity_share'
            ])->default('text');

            $table->text('content')->nullable();
            $table->string('attachment_url')->nullable();
            $table->string('attachment_name', 100)->nullable();
            $table->boolean('is_deleted')->default(false);

            // Thời gian gửi tin
            $table->timestamp('sent_at')->nullable();

            // Index tối ưu truy vấn
            $table->index(['conversation_id', 'sent_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};