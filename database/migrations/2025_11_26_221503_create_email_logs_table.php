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
        // Thêm dòng kiểm tra này:
        if (!Schema::hasTable('email_logs')) {
            Schema::create('email_logs', function (Blueprint $table) {
                $table->id();
                $table->string('recipient_type');
                $table->integer('recipient_count')->default(0);
                $table->string('subject');
                $table->unsignedBigInteger('sent_by')->nullable();
                $table->timestamp('sent_at')->useCurrent();
                $table->timestamps();

                $table->foreign('sent_by')->references('user_id')->on('users')->onDelete('set null');
            });
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
