<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán MoMo (ATM Nội địa)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .momo-pink { background-color: #a50064; }
        .momo-bg { background-color: #f4f7fa; }
    </style>
</head>
<body class="momo-bg h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden border border-gray-200">
        {{-- Header --}}
        <div class="momo-pink p-4 text-white flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="bg-white rounded p-1 w-8 h-8 flex items-center justify-center">
                   <svg viewBox="0 0 24 24" fill="none"><path d="M4.5 4.5V19.5H19.5V4.5H4.5Z" stroke="#a50064" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="#a50064"/></svg>
                </div>
                <div>
                    <h1 class="font-bold text-sm uppercase">Cổng thanh toán MoMo</h1>
                    <p class="text-[10px] opacity-80">Giả lập - Thẻ ATM Nội địa</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-xs opacity-90">Số tiền thanh toán</p>
                <p class="font-bold text-lg">{{ number_format($amount ?? 0, 0, ',', '.') }}đ</p>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-6">
            <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-6 flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm text-blue-800">
                    <p class="font-bold">Đơn hàng: {{ $orderInfo ?? 'Quyên góp' }}</p>
                    <p class="text-xs mt-1">Mã đơn: {{ $orderId }}</p>
                </div>
            </div>

            {{-- Form giả lập ATM --}}
            <div class="space-y-4 mb-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ngân hàng</label>
                    <select class="w-full border border-gray-300 rounded p-2.5 text-sm bg-gray-50">
                        <option>Vietcombank</option>
                        <option>Techcombank</option>
                        <option>MB Bank</option>
                        <option>BIDV</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Số thẻ</label>
                    <input type="text" value="9704 0000 0000 0018" readonly class="w-full border border-gray-300 rounded p-2.5 text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ngày phát hành</label>
                        <input type="text" value="03/12" readonly class="w-full border border-gray-300 rounded p-2.5 text-sm bg-gray-100 text-gray-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tên chủ thẻ</label>
                        <input type="text" value="NGUYEN VAN A" readonly class="w-full border border-gray-300 rounded p-2.5 text-sm bg-gray-100 text-gray-500">
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-3">
                {{-- Nút Thành công --}}
                <a href="{{ route('donation.momoReturn', [
                    'partnerCode' => 'MOMO_FAKE',
                    'orderId' => $orderId ?? time(),
                    'requestId' => $orderId ?? time(),
                    'amount' => $amount ?? 0,
                    'orderInfo' => $orderInfo ?? '',
                    'orderType' => 'momo_wallet',
                    'transId' => rand(100000, 999999),
                    'resultCode' => '0', 
                    'message' => 'Giao dịch thành công',
                    'payType' => 'qr',
                    'responseTime' => time(),
                    'extraData' => ''
                ]) }}" 
                class="block w-full momo-pink hover:bg-[#8d0056] text-white font-bold py-3 rounded-lg text-center transition shadow-md">
                    XÁC NHẬN THANH TOÁN
                </a>

                {{-- Nút Hủy --}}
                <a href="{{ route('donation.momoReturn', [
                    'resultCode' => '1006',
                    'orderId' => $orderId ?? time(),
                    'message' => 'Người dùng hủy giao dịch'
                ]) }}" 
                class="block w-full text-gray-500 hover:text-gray-700 text-sm font-semibold text-center py-2">
                    Hủy giao dịch
                </a>
            </div>
        </div>
        
        <div class="bg-gray-50 border-t p-3 text-center">
            <p class="text-[10px] text-gray-400">Simulation Environment</p>
        </div>
    </div>

</body>
</html>
