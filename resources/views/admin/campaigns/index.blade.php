{{-- index.blade.php - Danh sách chiến dịch --}}
@extends('layouts.admin')
@section('title', 'Quản lý Chiến dịch')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Chiến dịch Quyên góp</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Quản lý các chiến dịch từ thiện</p>
        </div>
        <a href="{{ route('admin.campaigns.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tạo Chiến dịch mới
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tổng chiến dịch</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $campaigns->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Đang hoạt động</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                        {{ $campaigns->where('status', 'Active')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tổng quyên góp</p>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">
                        {{ number_format($campaigns->sum('current_amount') / 1000000, 1) }}M
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Được ghim</p>
                    <p class="text-3xl font-bold text-orange-600 dark:text-orange-400 mt-2">
                        {{ $campaigns->where('is_pinned', true)->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Chiến dịch
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider" style="min-width: 280px;">
                            Tiến độ
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Ngày kết thúc
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($campaigns as $campaign)
                        @php
                            $progress = $campaign->target_amount > 0 
                                ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) 
                                : 0;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    @if($campaign->is_pinned)
                                        <div class="flex-shrink-0 w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v16l-5-2.5L5 21V5z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold text-gray-900 dark:text-white truncate">
                                            {{ $campaign->title }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            ID: {{ $campaign->id }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($campaign->status == 'Active')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 bg-green-600 dark:bg-green-400 rounded-full mr-2"></span>
                                        Hoạt động
                                    </span>
                                @elseif($campaign->status == 'Paused')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400">
                                        <span class="w-1.5 h-1.5 bg-yellow-600 dark:bg-yellow-400 rounded-full mr-2"></span>
                                        Tạm dừng
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400">
                                        <span class="w-1.5 h-1.5 bg-gray-600 dark:bg-gray-400 rounded-full mr-2"></span>
                                        Kết thúc
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            {{ number_format($campaign->current_amount, 0, ',', '.') }}đ
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400">
                                            {{ number_format($campaign->target_amount, 0, ',', '.') }}đ
                                        </span>
                                    </div>
                                    <div class="relative w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                        <div class="absolute h-full transition-all duration-500 rounded-full {{ $progress >= 100 ? 'bg-gradient-to-r from-green-500 to-green-600' : 'bg-gradient-to-r from-blue-500 to-blue-600' }}" 
                                             style="width: {{ $progress }}%">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-bold {{ $progress >= 100 ? 'text-green-600 dark:text-green-400' : 'text-blue-600 dark:text-blue-400' }}">
                                            {{ number_format($progress, 1) }}%
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white font-medium">
                                    {{ $campaign->end_date->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $campaign->end_date->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.campaigns.showDonations', $campaign->id) }}" 
                                       class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                       title="Xem quyên góp">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" 
                                       class="p-2 text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/30 rounded-lg transition-colors"
                                       title="Chỉnh sửa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium mb-2">Chưa có chiến dịch nào</p>
                                    <a href="{{ route('admin.campaigns.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                        Tạo chiến dịch đầu tiên →
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($campaigns->hasPages())
        <div class="mt-6">
            {{ $campaigns->links() }}
        </div>
    @endif
</div>
@endsection