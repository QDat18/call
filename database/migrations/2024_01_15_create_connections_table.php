<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id('connection_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('friend_id');
            $table->enum('status', ['pending', 'accepted', 'blocked'])->default('pending');
            $table->unsignedBigInteger('action_user_id')->nullable()->comment('User who initiated or last modified');
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('friend_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('action_user_id')->references('user_id')->on('users')->onDelete('set null');

            $table->index(['user_id', 'status']);
            $table->index(['friend_id', 'status']);
            $table->unique(['user_id', 'friend_id'], 'unique_connection');
        });

        // Tạo trigger ngăn duplicate connection
        DB::unprepared('
            CREATE TRIGGER prevent_duplicate_connection
            BEFORE INSERT ON connections
            FOR EACH ROW
            BEGIN
                IF EXISTS (
                    SELECT 1 FROM connections 
                    WHERE user_id = NEW.friend_id AND friend_id = NEW.user_id
                ) THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Connection already exists in reverse direction";
                END IF;
            END
        ');
    }

    public function down(): void
    {
        // Xóa trigger trước khi drop table
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_duplicate_connection');
        Schema::dropIfExists('connections');
    }
};
