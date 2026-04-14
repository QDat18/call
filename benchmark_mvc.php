<?php

use Illuminate\Http\Request;
use App\Http\Controllers\VolunteerOpportunityController;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Giả lập request với đầy đủ thông số IP để tránh lỗi Middleware
$request = Request::create('/opportunities', 'GET', [], [], [], [
    'REMOTE_ADDR' => 'https://call-l3q5.onrender.com'
]);
$kernel->handle($request); 

$controller = new VolunteerOpportunityController();

$iterations = 1000;
$totalTime = 0;

echo "--- ĐO LƯỜNG TRẠNG THÁI BAN ĐẦU (1000 LẦN) ---\n";
echo "Đang xử lý...\n";

// Xóa cache trước khi đo để đảm bảo trạng thái "ban đầu"
\Illuminate\Support\Facades\Cache::flush();

for ($i = 0; $i < $iterations; $i++) {
    $start = microtime(true);
    
    // Gọi trực tiếp hàm index của Controller (Flow: Controller -> Model -> DB)
    // Tránh render View để lấy thời gian xử lý logic chính xác hơn
    $result = $controller->index($request);
    
    $end = microtime(true);
    $totalTime += ($end - $start);
    
    if (($i + 1) % 100 == 0) {
        echo "Hoàn thành " . ($i + 1) . " lượt...\n";
    }
}

$averageTime = ($totalTime / $iterations) * 1000; // ms

echo "\n--- KẾT QUẢ ĐO LƯỜNG LẦN 1 ---\n";
echo "Tổng số lần chạy: $iterations\n";
echo "Tổng thời gian: " . number_format($totalTime, 4) . " giây\n";
echo "Thời gian trung bình: " . number_format($averageTime, 2) . " ms/request\n";
echo "-------------------------------\n";
