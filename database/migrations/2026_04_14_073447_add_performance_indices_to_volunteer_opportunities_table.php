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
        Schema::table('volunteer_opportunities', function (Blueprint $table) {
            // Composite indices for typical filtering + sorting combinations
            $table->index(['status', 'created_at'], 'idx_status_created_at');
            $table->index(['status', 'application_count'], 'idx_status_popular');
            $table->index(['status', 'application_deadline'], 'idx_status_urgent');
            $table->index(['status', 'category_id', 'created_at'], 'idx_status_cat_created');
            $table->index(['status', 'location'], 'idx_status_location');
            $table->index(['status', 'time_commitment'], 'idx_status_commitment');
            $table->index(['status', 'experience_needed'], 'idx_status_experience');
            
            // Full-text for location to replace LIKE
            $table->fullText('location', 'ft_location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteer_opportunities', function (Blueprint $table) {
            $table->dropIndex('idx_status_created_at');
            $table->dropIndex('idx_status_popular');
            $table->dropIndex('idx_status_urgent');
            $table->dropIndex('idx_status_cat_created');
            $table->dropIndex('idx_status_location');
            $table->dropIndex('idx_status_commitment');
            $table->dropIndex('idx_status_experience');
            $table->dropFullText('ft_location');
        });
    }
};
