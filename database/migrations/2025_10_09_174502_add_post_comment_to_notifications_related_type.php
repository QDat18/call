<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Thêm 'post', 'comment' và 'conversation' vào enum related_type
        DB::statement("
            ALTER TABLE notifications 
            MODIFY related_type ENUM(
                'application', 
                'opportunity', 
                'message', 
                'call', 
                'user', 
                'post', 
                'comment', 
                'conversation'
            ) NULL
        ");
    }

    public function down(): void
    {
        // Rollback về enum cũ (không có post, comment, conversation)
        DB::statement("
            ALTER TABLE notifications 
            MODIFY related_type ENUM(
                'application', 
                'opportunity', 
                'message', 
                'call', 
                'user'
            ) NULL
        ");
    }
};
