@extends('layouts.admin') {{-- Giả sử bạn có layout admin --}}
@section('title', 'Lịch sử Quyên góp')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.campaigns.index') }}" class="text-blue-500 hover:underline">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại Danh sách Chiến dịch
        </a>
        <h1 class="text-3xl font-bold mt-2">Chiến dịch: {{ $campaign->title }}</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm font-medium text-gray-500">Đã đạt được</div>
            <div class="text-2xl font-bold text-green-600">{{ number_format($campaign->current_amount) }} VNĐ</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm font-medium text-gray-500">Mục tiêu</div>
            <div class="text-2xl font-bold text-gray-800">{{ number_format($campaign->target_amount) }} VNĐ</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm font-medium text-gray-500">Tổng số lượt (thành công)</div>
            <div class="text-2xl font-bold text-blue-600">{{ $donations->total() }}</div>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4">Danh sách Quyên góp (Thành công)</h2>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Người Quyên góp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số tiền</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lời nhắn</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mã VNPay</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($donations as $donation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full mr-3" src="{{ $donation->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($donation->user->first_name) }}" alt="">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $donation->user->first_name }} {{ $donation->user->last_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $donation->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-green-600">{{ number_format($donation->amount) }} VNĐ</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $donation->message ?? '...' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $donation->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $donation->vnp_TransactionNo }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Chưa có ai quyên góp cho chiến dịch này.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $donations->links() }}
    </div>
@endsection