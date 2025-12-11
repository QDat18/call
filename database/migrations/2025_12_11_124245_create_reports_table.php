<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade'); // Người báo cáo
            $table->unsignedBigInteger('target_id'); // ID bài viết (hoặc comment/user...)
            $table->string('target_type'); // 'post', 'comment', 'user'
            $table->string('reason'); // Lý do: spam, harassment, etc.
            $table->text('description')->nullable(); // Chi tiết thêm
            $table->enum('status', ['Pending', 'Resolved', 'Dismissed'])->default('Pending');
            $table->string('resolution')->nullable(); // Kết quả xử lý
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
