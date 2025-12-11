@extends('layouts.admin')
@section('title', 'Quản lý Chiến dịch')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Chiến dịch Quyên góp</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Quản lý các hoạt động từ thiện và gây quỹ</p>
        </div>
        <a href="{{ route('admin.campaigns.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tạo Mới
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach ([
            ['label' => 'Tổng chiến dịch', 'value' => $campaigns->total(), 'color' => 'blue', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
            ['label' => 'Đang hoạt động', 'value' => $campaigns->where('status', 'Active')->count(), 'color' => 'green', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Tổng quyên góp (Triệu)', 'value' => number_format($campaigns->sum('current_amount') / 1000000, 1) . 'M', 'color' => 'purple', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Ghim trang chủ', 'value' => $campaigns->where('is_pinned', true)->count(), 'color' => 'orange', 'icon' => 'M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z']
        ] as $stat)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex items-center justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stat['value'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 flex items-center justify-center text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Chiến dịch</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider w-1/4">Tiến độ</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kết thúc</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                    @forelse($campaigns as $campaign)
                        @php
                            $progress = $campaign->target_amount > 0 ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) : 0;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $campaign->banner_image_url ? asset('storage/' . $campaign->banner_image_url) : 'https://via.placeholder.com/150' }}" 
                                         class="h-12 w-16 object-cover rounded-lg border border-gray-200 dark:border-gray-700" alt="Banner">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="font-semibold text-gray-900 dark:text-white truncate max-w-xs">{{ $campaign->title }}</p>
                                            @if($campaign->is_pinned)
                                                <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v16l-5-2.5L5 21V5z"/></svg>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">ID: #{{ $campaign->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $campaign->status == 'Active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 
                                      ($campaign->status == 'Paused' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 
                                       'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                    {{ $campaign->status == 'Active' ? 'Hoạt động' : ($campaign->status == 'Paused' ? 'Tạm dừng' : 'Kết thúc') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="w-full max-w-xs">
                                    <div class="flex justify-between text-xs mb-1.5">
                                        <span class="font-semibold text-gray-700 dark:text-gray-200">{{ number_format($campaign->current_amount) }}đ</span>
                                        <span class="text-gray-500 dark:text-gray-400">{{ number_format($campaign->target_amount) }}đ</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full {{ $progress >= 100 ? 'bg-green-500' : 'bg-blue-600' }} transition-all duration-500" 
                                             style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                <div>{{ $campaign->end_date->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $campaign->end_date->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.campaigns.showDonations', $campaign->id) }}" 
                                       class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition" title="Lịch sử quyên góp">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </a>
                                    <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" 
                                       class="p-2 text-gray-500 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-gray-700 rounded-lg transition" title="Chỉnh sửa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    <p class="font-medium">Chưa có chiến dịch nào.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($campaigns->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
</div>
@endsection