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
        Schema::create('donations', function (Blueprint $table) {
            $table->id(); // <-- Đây sẽ là 'vnp_TxnRef' (mã đơn hàng) của chúng ta
            
            // Liên kết với chiến dịch
            $table->foreignId('campaign_id')->constrained('donation_campaigns')->onDelete('cascade');
            
            // Liên kết với người quyên góp (TNV hoặc Tổ chức)
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            
            $table->bigInteger('amount'); // Số tiền
            $table->string('message')->nullable(); // Lời nhắn
            
            // Trạng thái giao dịch
            $table->string('status')->default('Pending'); // Pending, Success, Failed
            
            // Mã giao dịch do VNPay trả về (để đối soát)
            $table->string('vnp_TransactionNo')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};