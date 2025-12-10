<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    public function up(): void
    {
        // Nếu bảng chưa tồn tại mới tạo
        if (!Schema::hasTable('vn_locations')) {

            Schema::create('vn_locations', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('full_name', 255)->nullable();
                $table->string('full_path', 255)->nullable();
                $table->string('code', 20)->unique()->index();
                $table->string('level', 20)->nullable();
                $table->string('parent_code', 20)->nullable()->index();
            });
        }

        // Import SQL
        $sqlFile = __DIR__ . '/vn_locations.sql';

        if (file_exists($sqlFile)) {
            $sql = File::get($sqlFile);

            // Nếu data chưa có mới import
            if (DB::table('vn_locations')->count() == 0) {
                DB::unprepared($sql);

                DB::table('vn_locations')
                    ->whereNull('full_path')
                    ->update(['full_path' => DB::raw('full_name')]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('vn_locations');
    }
};
