@extends('layouts.admin')
@section('title', 'Lịch sử Quyên góp - ' . $campaign->title)

@section('content')
    <div class="p-6 max-w-7xl mx-auto space-y-6">

        {{-- 1. Header Section --}}
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-1">
                    <a href="{{ route('admin.campaigns.index') }}" class="hover:text-indigo-600 transition">Chiến dịch</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span>Chi tiết quyên góp</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    {{ $campaign->title }}
                    @if($campaign->status == 'Active')
                        <span
                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-600 inline-block mr-1"></span> Hoạt động
                        </span>
                    @else
                        <span
                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            Đã kết thúc
                        </span>
                    @endif
                </h1>
            </div>

            <div class="flex gap-3">
                {{-- NÚT EXPORT EXCEL ĐÃ SỬA --}}
                <a href="{{ route('admin.campaigns.export-donations', $campaign->id) }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-sm transition transform hover:-translate-y-0.5 no-print">
                    <i class="fas fa-file-excel mr-2"></i> Xuất Excel
                </a>

                <a href="{{ route('admin.campaigns.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm no-print">
                    <i class="fas fa-arrow-left mr-2"></i> Quay lại
                </a>
            </div>
        </div>

        {{-- 2. Stats Overview (Grid 4) --}}
        @php
            // 1. Tính tiến độ (giữ nguyên)
            $progress = $campaign->target_amount > 0
                ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100)
                : 0;

            // 2. Xác định hạn chót là cuối ngày (23:59:59)
            $deadline = $campaign->end_date->copy()->endOfDay();

            // 3. Kiểm tra đã quá hạn chưa (So sánh thời gian thực)
            $isOverdue = $deadline->isPast();

            // 4. Tính số ngày còn lại (FIX LỖI TẠI ĐÂY)
            if ($isOverdue) {
                $daysLeft = 0;
            } else {
                // diffInDays() mặc định lấy trị tuyệt đối -> Luôn Dương
                // Nó trả về số nguyên (Integer) -> Không còn số lẻ thập phân
                $daysLeft = ceil(now()->diffInDays($deadline) + (now()->diffInHours($deadline) % 24) / 24);
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Đã quyên góp</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span
                        class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($campaign->current_amount, 0, ',', '.') }}</span>
                    <span class="text-xs font-medium text-gray-500">VNĐ</span>
                </div>
                <div
                    class="mt-2 text-xs text-green-600 font-medium bg-green-50 dark:bg-green-900/30 px-2 py-1 rounded-lg inline-block">
                    {{ number_format($progress, 1) }}% mục tiêu
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Mục tiêu chiến dịch</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span
                        class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                    <span class="text-xs font-medium text-gray-500">VNĐ</span>
                </div>
                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5 mt-3">
                    <div class="bg-indigo-600 h-1.5 rounded-full transition-all duration-1000"
                        style="width: {{ $progress }}%"></div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Lượt ủng hộ</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">{{ $donations->total() }}</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Thời gian
                            {{ $isOverdue ? 'Kết thúc' : 'Còn lại' }}
                        </p>
                        <p
                            class="text-2xl font-bold mt-2 {{ $isOverdue ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">
                            @if($isOverdue)
                                <span class="text-lg">{{ $campaign->end_date->diffForHumans(now(), true) }} trước</span>
                            @else
                                {{ $daysLeft }} <span class="text-xs font-normal text-gray-500">ngày</span>
                            @endif
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full {{ $isOverdue ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center">
                        <i class="far fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Data Table --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            {{-- Toolbar (Print) --}}
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gray-50/50 dark:bg-gray-800">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Danh sách giao dịch</h2>
                    <p class="text-sm text-gray-500">Lịch sử quyên góp chi tiết qua cổng thanh toán.</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="window.print()"
                        class="no-print inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-xl hover:bg-gray-50 transition shadow-sm">
                        <i class="fas fa-print mr-2"></i> In báo cáo
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase text-gray-500 dark:text-gray-400 font-semibold">
                        <tr>
                            <th class="px-6 py-4">Người quyên góp</th>
                            <th class="px-6 py-4">Số tiền</th>
                            <th class="px-6 py-4">Lời nhắn</th>
                            <th class="px-6 py-4">Thời gian</th>
                            <th class="px-6 py-4">Mã giao dịch</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm">
                        @forelse($donations as $donation)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img class="w-8 h-8 rounded-full object-cover border border-gray-200"
                                            src="{{ $donation->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($donation->user->first_name) . '&background=random' }}"
                                            alt="">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                {{ $donation->user->first_name }} {{ $donation->user->last_name }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $donation->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        +{{ number_format($donation->amount, 0, ',', '.') }} đ
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($donation->message)
                                        <div class="max-w-xs truncate text-gray-600 dark:text-gray-300"
                                            title="{{ $donation->message }}">
                                            {{ $donation->message }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Không có lời nhắn</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    {{ $donation->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <code
                                        class="px-2 py-1 bg-gray-100 dark:bg-gray-900 rounded text-xs font-mono text-gray-600 dark:text-gray-400">
                                                                    {{ $donation->vnp_TransactionNo ?? 'N/A' }}
                                                                </code>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
                                        <p>Chưa có lượt quyên góp nào.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($donations->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* CSS cho Print (Giữ nguyên) */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .dark\:bg-gray-800 {
                background: white !important;
                color: black !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
@endsection