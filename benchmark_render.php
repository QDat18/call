<?php

$url = "https://call-l3q5.onrender.com/opportunities";
$iterations = 100; // Đặt 100 để test nhanh, bạn có thể sửa thành 1000 cho báo cáo
$totalTime = 0;
$successCount = 0;
$errorCount = 0;

echo "--- ĐO LƯỜNG HỆ THỐNG TRÊN RENDER (LIVE) ---\n";
echo "Mục tiêu: $url\n";
echo "Số lượt yêu cầu: $iterations\n";
echo "Đang xử lý (Vui lòng đợi)...\n\n";

for ($i = 0; $i < $iterations; $i++) {
    $start = microtime(true);
    
    // Sử dụng cURL để gọi URL thật
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $end = microtime(true);
    $latency = ($end - $start);
    
    if ($httpCode == 200) {
        $totalTime += $latency;
        $successCount++;
    } else {
        $errorCount++;
    }

    if (($i + 1) % 10 == 0) {
        echo "Đã xong " . ($i + 1) . " lượt...\n";
    }
}

if ($successCount > 0) {
    $averageTime = ($totalTime / $successCount) * 1000;
    echo "\n--- KẾT QUẢ ĐO LƯỜNG RENDER ---\n";
    echo "Thành công: $successCount\n";
    echo "Lỗi: $errorCount\n";
    echo "Thời gian trung bình: " . number_format($averageTime, 2) . " ms/request\n";
    echo "-------------------------------\n";
} else {
    echo "\nKhông có yêu cầu nào thành công. Vui lòng kiểm tra lại kết nối hoặc Server.\n";
}
