<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán MoMo (Môi trường Giả lập)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .momo-pink { background-color: #a50064; }
        .momo-pink-hover:hover { background-color: #8d0056; }
        .momo-text { color: #a50064; }
    </style>
</head>
<body class="bg-[#f0f2f5] h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
        {{-- Header --}}
        <div class="momo-pink p-4 text-white flex justify-between items-center">
            <div class="flex items-center gap-2">
                {{-- Logo MoMo giả --}}
                <div class="bg-white rounded p-1 w-8 h-8 flex items-center justify-center">
                   <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 4.5V19.5H19.5V4.5H4.5Z" stroke="#a50064" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="#a50064"/></svg>
                </div>
                <span class="font-bold text-lg">Cổng thanh toán</span>
            </div>
            <span class="text-[10px] uppercase font-bold bg-white/20 px-2 py-1 rounded border border-white/30 tracking-wider">
                Simulation Mode
            </span>
        </div>

        {{-- Body --}}
        <div class="p-6 flex flex-col items-center text-center">
            <div class="w-full border-b border-gray-100 pb-4 mb-4">
                <p class="text-gray-500 text-sm mb-1">Đơn hàng từ <strong>Volunteer Connect</strong></p>
                <p class="text-xs text-gray-400 truncate w-full">{{ $orderInfo ?? 'Quyên góp chiến dịch' }}</p>
            </div>
            
            <h2 class="text-4xl font-bold momo-text mb-6">
                {{ number_format($amount ?? 0, 0, ',', '.') }}đ
            </h2>

            {{-- Fake QR Code --}}
            <div class="relative group mb-6">
                <div class="p-3 border-2 border-[#a50064] rounded-xl bg-white shadow-sm">
                    {{-- Tạo QR Code từ Google API --}}
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=MOMO_SIMULATION_{{ $orderId ?? time() }}" 
                         alt="QR Code" 
                         class="w-48 h-48 object-contain">
                </div>
                <div class="mt-3 flex items-center justify-center gap-2 text-sm text-gray-500">
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#a50064] opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-[#a50064]"></span>
                    </span>
                    Đang chờ quét mã...
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-100 text-blue-800 text-xs p-3 rounded-lg mb-6 w-full text-left flex gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                <div>
                    <strong>Chế độ Demo:</strong><br>
                    Không cần mở điện thoại. Bấm nút bên dưới để giả lập kết quả trả về từ MoMo.
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-3 w-full">
                {{-- Nút Thành công --}}
                <a href="{{ route('donation.momoReturn', [
                    'partnerCode' => 'MOMO_FAKE',
                    'orderId' => $orderId ?? time(),
                    'requestId' => $orderId ?? time(),
                    'amount' => $amount ?? 0,
                    'orderInfo' => $orderInfo ?? '',
                    'orderType' => 'momo_wallet',
                    'transId' => rand(100000, 999999),
                    'resultCode' => '0', // 0 = Thành công
                    'message' => 'Giao dịch thành công',
                    'payType' => 'qr',
                    'responseTime' => time(),
                    'extraData' => ''
                ]) }}" 
                class="block w-full momo-pink momo-pink-hover text-white font-bold py-3.5 rounded-xl transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Giả lập: Thanh toán THÀNH CÔNG
                </a>

                {{-- Nút Thất bại --}}
                <a href="{{ route('donation.momoReturn', [
                    'resultCode' => '1006', // Mã lỗi người dùng hủy
                    'orderId' => $orderId ?? time(),
                    'message' => 'Người dùng hủy giao dịch'
                ]) }}" 
                class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3.5 rounded-xl transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Giả lập: Hủy / Thất bại
                </a>
            </div>
        </div>
        
        <div class="bg-gray-50 border-t p-3 text-center">
            <p class="text-[10px] text-gray-400">Secured by Volunteer Connect Simulation</p>
        </div>
    </div>

</body>
</html>
