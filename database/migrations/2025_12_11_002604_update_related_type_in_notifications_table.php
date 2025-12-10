<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE notifications 
            MODIFY COLUMN related_type 
            ENUM(
                'application',
                'opportunity',
                'message',
                'call',
                'user',
                'post',
                'comment',
                'conversation',
                'activity',
                'other'
            ) 
            DEFAULT 'other'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback về ENUM cũ (8 giá trị ban đầu)
        DB::statement("
            ALTER TABLE notifications 
            MODIFY COLUMN related_type 
            ENUM(
                'application',
                'opportunity',
                'message',
                'call',
                'user',
                'post',
                'comment',
                'conversation'
            )
        ");
    }
};
