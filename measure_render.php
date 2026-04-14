<?php

$url = "https://call-1-7ypz.onrender.com/opportunities";
$iterations = 10;
$totalTime = 0;
$successCount = 0;

echo "--- ĐO LƯỜNG HIỆU NĂNG RENDER (10 LẦN) ---\n";
echo "Mục tiêu: $url\n\n";

for ($i = 1; $i <= $iterations; $i++) {
    $start = microtime(true);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $end = microtime(true);
    $elapsed = $end - $start;
    
    if ($httpCode === 200) {
        $totalTime += $elapsed;
        $successCount++;
        echo "Lần $i: " . number_format($elapsed, 4) . " giây [OK]\n";
    } else {
        echo "Lần $i: Thất bại (Mã lỗi: $httpCode)\n";
    }
    
    usleep(200000); // Nghỉ 0.2s giữa các lần test
}

if ($successCount > 0) {
    $avg = ($totalTime / $successCount);
    echo "\n--- KẾT QUẢ CUỐI CÙNG ---\n";
    echo "Thời gian trung bình: " . number_format($avg, 4) . " giây\n";
    echo "Tỉ lệ thành công: " . ($successCount / $iterations * 100) . "%\n";
    
    if ($avg < 0.8) {
        echo "TRẠNG THÁI: TỐI ƯU (ĐẠT MỤC TIÊU 0.77s)\n";
    } else {
        echo "TRẠNG THÁI: CẦN KIỂM TRA LẠI\n";
    }
} else {
    echo "\nLỖI: Không thể đo lường được do toàn bộ request thất bại.\n";
}
