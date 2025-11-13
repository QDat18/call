@extends('layouts.app')

@section('title', 'Đơn Ứng Tuyển Của Tôi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-purple-800">Đơn Ứng Tuyển</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-purple-100">
            <!-- Filter Form -->
            <form method="GET" class="p-6 border-b border-purple-100 flex gap-4">
                <select name="status" class="flex-1 p-3 border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-300">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="Under Review" {{ request('status') == 'Under Review' ? 'selected' : '' }}>Đang xem xét</option>
                    <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Đã chấp nhận</option>
                    <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Từ chối</option>
                </select>
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 rounded-xl font-semibold hover:shadow-xl transition">Lọc</button>
            </form>

            <!-- Applications List -->
            <div class="divide-y divide-purple-100">
                @forelse($applications as $app)
                    <div class="p-6 hover:bg-purple-50 transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <a href="{{ route('volunteer.applications.show', $app->application_id) }}" class="font-semibold text-purple-800 hover:text-purple-600 text-lg">
                                    {{ $app->opportunity->title }}
                                </a>
                                <div class="text-sm text-gray-600 mt-1">{{ $app->opportunity->organization->organization_name }}</div>
                                <div class="text-sm text-gray-500 mt-2">Ứng tuyển ngày: {{ $app->applied_date->format('d/m/Y') }}</div>
                            </div>
                            <span class="px-4 py-2 rounded-full font-medium {{ $app->status == 'Accepted' ? 'bg-green-100 text-green-800' : ($app->status == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $app->status }}
                            </span>
                        </div>
                        @if($app->status == 'Rejected')
                            <p class="text-sm text-red-600 mt-3">Lý do: {{ $app->organization_notes ?? 'Không có ghi chú' }}</p>
                        @endif
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500">
                        <i class="fas fa-file-times text-6xl mb-4 text-purple-300"></i>
                        <p class="text-xl">Chưa có đơn ứng tuyển nào</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection