<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donation_campaigns', function (Blueprint $table) {
            $table->id();
            // Khóa ngoại liên kết với Admin (bảng users)
            // Đảm bảo 'user_id' khớp với khóa chính của bảng 'users' của bạn
            $table->foreignId('admin_user_id')->constrained('users', 'user_id')->onDelete('cascade');
            
            $table->string('title'); // Tiêu đề chiến dịch
            $table->text('description'); // Nội dung chi tiết
            $table->string('banner_image_url')->nullable(); // Ảnh banner cho slide
            
            // Số tiền (dùng bigInteger cho VNĐ là đơn giản nhất)
            $table->bigInteger('target_amount')->default(0); // Mục tiêu
            $table->bigInteger('current_amount')->default(0); // Đã đạt được
            
            $table->dateTime('end_date'); // Ngày kết thúc
            $table->string('status')->default('Active'); // Trạng thái: Active, Paused, Ended
            
            // Cột quan trọng cho slider: cho phép ghim NHIỀU chiến dịch
            $table->boolean('is_pinned')->default(false); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_campaigns');
    }
};