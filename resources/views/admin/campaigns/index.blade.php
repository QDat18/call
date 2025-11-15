@extends('layouts.admin')
@section('title', 'Quản lý Chiến dịch')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Chiến dịch Quyên góp</h1>
        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">
            <i class="fas fa-plus mr-2"></i>Tạo Chiến dịch mới
        </a>
    </div>

    {{-- Thêm Giao diện lọc (search/status) ở đây nếu cần --}}

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiêu đề</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Đã ghim (Pin)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase" style="min-width: 250px;">Tiến độ</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày kết thúc</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($campaigns as $campaign)
                    @php
                        $progress = $campaign->target_amount > 0 
                            ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) 
                            : 0;
                    @endphp
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $campaign->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{-- Thêm logic màu sắc cho status --}}
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $campaign->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $campaign->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($campaign->is_pinned)
                                <i class="fas fa-thumbtack text-blue-500"></i>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs text-gray-600">
                                    <span class="font-medium">{{ number_format($campaign->current_amount, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-gray-500">{{ number_format($campaign->target_amount, 0, ',', '.') }} VNĐ</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full transition-all duration-300 
                                        {{ $progress >= 100 ? 'bg-green-600' : 'bg-blue-600' }}" 
                                        style="width: {{ $progress }}%">
                                    </div>
                                </div>
                                <div class="text-xs text-right font-semibold
                                    {{ $progress >= 100 ? 'text-green-600' : 'text-blue-600' }}">
                                    {{ number_format($progress, 1) }}%
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $campaign->end_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.campaigns.showDonations', $campaign->id) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Xem quyên góp"><i class="fas fa-users"></i></a>
                            <a href="{{ route('admin.campaigns.edit', $campaign->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Sửa"><i class="fas fa-edit"></i></a>
                            {{-- Thêm form Delete --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Chưa có chiến dịch nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $campaigns->links() }}
    </div>
@endsection