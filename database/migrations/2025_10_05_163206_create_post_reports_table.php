<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedInteger('reporter_id');
            $table->enum('reason', [
                'spam',
                'inappropriate',
                'harassment',
                'false_information',
                'hate_speech',
                'violence',
                'other'
            ]);
            $table->text('description')->nullable();
            $table->enum('status', [
                'pending',
                'under_review',
                'resolved',
                'dismissed'
            ])->default('pending');
            $table->unsignedInteger('reviewed_by')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            
            // TẠM THỜI BỎ FOREIGN KEYS ĐỂ TEST
            // Có thể thêm lại sau bằng migration khác
            
            $table->index(['status', 'created_at']);
            $table->index('post_id');
            $table->index('reporter_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_reports');
    }
};