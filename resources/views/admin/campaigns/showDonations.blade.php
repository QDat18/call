@extends('layouts.admin')
@section('title', 'Lịch sử Quyên góp - ' . $campaign->title)

@section('content')
<div class="p-6">
    {{-- Header with Breadcrumb --}}
    <div class="mb-8">
        <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
            <a href="{{ route('admin.campaigns.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">
                Chiến dịch
            </a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900 dark:text-white font-medium">Lịch sử quyên góp</span>
        </nav>
        
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $campaign->title }}</h1>
                <p class="text-gray-600 dark:text-gray-400">Theo dõi các khoản quyên góp thành công</p>
            </div>
            <a href="{{ route('admin.campaigns.index') }}" 
               class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Quay lại
            </a>
        </div>
    </div>

    {{-- Campaign Status Badge --}}
    <div class="mb-6">
        @if($campaign->status == 'Active' && $campaign->end_date > now())
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                <span class="w-2 h-2 bg-green-600 dark:bg-green-400 rounded-full mr-2 animate-pulse"></span>
                Đang hoạt động
            </span>
        @else
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400 border border-gray-200 dark:border-gray-600">
                <span class="w-2 h-2 bg-gray-600 dark:bg-gray-400 rounded-full mr-2"></span>
                Đã kết thúc
            </span>
        @endif
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- Đã quyên góp --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-32 w-32 rounded-full bg-white/10"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-green-100 text-sm font-medium">Đã quyên góp</p>
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold mb-1">{{ number_format($campaign->current_amount / 1000000, 1) }}M</p>
                <p class="text-green-100 text-xs">{{ number_format($campaign->current_amount, 0, ',', '.') }} VNĐ</p>
            </div>
        </div>

        {{-- Mục tiêu --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-32 w-32 rounded-full bg-white/10"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-blue-100 text-sm font-medium">Mục tiêu</p>
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold mb-1">{{ number_format($campaign->target_amount / 1000000, 1) }}M</p>
                <p class="text-blue-100 text-xs">{{ number_format($campaign->target_amount, 0, ',', '.') }} VNĐ</p>
            </div>
        </div>

        {{-- Lượt quyên góp --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-32 w-32 rounded-full bg-white/10"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-purple-100 text-sm font-medium">Lượt quyên góp</p>
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold mb-1">{{ $donations->total() }}</p>
                <p class="text-purple-100 text-xs">Nhà hảo tâm</p>
            </div>
        </div>

        {{-- Tiến độ --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-white/10"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 h-32 w-32 rounded-full bg-white/10"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-orange-100 text-sm font-medium">Tiến độ</p>
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                @php
                    $progress = $campaign->target_amount > 0 
                        ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) 
                        : 0;
                @endphp
                <p class="text-4xl font-bold mb-2">{{ number_format($progress, 1) }}%</p>
                <div class="w-full bg-orange-400/30 rounded-full h-2 overflow-hidden">
                    <div class="bg-white rounded-full h-2 transition-all duration-1000 ease-out shadow-lg" 
                         style="width: {{ $progress }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        {{-- Table Header --}}
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Danh sách Quyên góp</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Các giao dịch thành công qua VNPay</p>
                </div>
                <button onclick="window.print()" 
                        class="no-print inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 shadow-sm transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    In báo cáo
                </button>
            </div>
        </div>
        
        {{-- Table Body --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Người quyên góp
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Số tiền
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Lời nhắn
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Thời gian
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Mã GD VNPay
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($donations as $index => $donation)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    {{ $donations->firstItem() + $index }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700 shadow-sm" 
                                             src="{{ $donation->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($donation->user->first_name) . '&background=6366f1&color=fff' }}" 
                                             alt="{{ $donation->user->first_name }}">
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $donation->user->first_name }} {{ $donation->user->last_name }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                            {{ $donation->user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ number_format($donation->amount, 0, ',', '.') }}đ
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($donation->message)
                                    <div class="max-w-md">
                                        <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2">
                                            {{ $donation->message }}
                                        </p>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400 dark:text-gray-500 italic">Không có lời nhắn</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $donation->created_at->format('d/m/Y') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $donation->created_at->format('H:i:s') }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($donation->vnp_TransactionNo)
                                    <code class="inline-flex items-center px-3 py-1.5 text-xs font-mono bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300 rounded-lg border border-gray-200 dark:border-gray-700">
                                        <svg class="w-3 h-3 mr-1.5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $donation->vnp_TransactionNo }}
                                    </code>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Chưa có quyên góp nào</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mb-4">
                                        Chiến dịch này chưa nhận được khoản quyên góp nào. Hãy chia sẻ để thu hút nhiều người tham gia hơn!
                                    </p>
                                    <a href="{{ route('campaign.show', $campaign->id) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Xem trang công khai
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($donations->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                {{ $donations->links() }}
            </div>
        @endif
    </div>

    {{-- Summary Footer --}}
    @if($donations->count() > 0)
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-300">Tóm tắt</h3>
                    <div class="mt-2 text-sm text-blue-800 dark:text-blue-400">
                        <p>Trang này hiển thị <strong>{{ $donations->count() }}</strong> giao dịch trong tổng số <strong>{{ $donations->total() }}</strong> lượt quyên góp thành công.</p>
                        <p class="mt-1">Tổng số tiền đã nhận: <strong>{{ number_format($campaign->current_amount, 0, ',', '.') }} VNĐ</strong> ({{ number_format($progress, 1) }}% mục tiêu)</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    body {
        background: white !important;
    }
    .dark\:bg-gray-800 {
        background: white !important;
    }
    .dark\:text-white {
        color: black !important;
    }
}
</style>
@endsection