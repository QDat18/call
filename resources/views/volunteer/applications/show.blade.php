@extends('layouts.app')

@section('title', 'Chi Tiết Đơn Ứng Tuyển')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12 px-4">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-purple-100">
        <div class="p-8 border-b border-purple-100">
            <h1 class="text-3xl font-bold mb-4 text-purple-800">{{ $application->opportunity->title }}</h1>
            <div class="flex items-center gap-6 text-sm text-gray-600">
                <span>Trạng thái: <span class="font-medium {{ $application->status == 'Accepted' ? 'text-green-600' : ($application->status == 'Pending' ? 'text-yellow-600' : 'text-red-600') }}">{{ $application->status }}</span></span>
                <span>Ứng tuyển ngày: {{ $application->applied_date->format('d/m/Y') }}</span>
                @if($application->reviewed_date)
                    <span>Xem xét ngày: {{ $application->reviewed_date->format('d/m/Y') }}</span>
                @endif
            </div>
        </div>

        <div class="p-8">
            <h2 class="font-semibold text-lg mb-3 text-purple-700">Tổ chức</h2>
            <p class="text-gray-700 mb-6">{{ $application->opportunity->organization->organization_name }}</p>

            <h2 class="font-semibold text-lg mb-3 text-purple-700">Lý do ứng tuyển</h2>
            <p class="text-gray-700 mb-6 leading-relaxed">{{ $application->motivation_letter }}</p>

            <h2 class="font-semibold text-lg mb-3 text-purple-700">Kinh nghiệm liên quan</h2>
            <p class="text-gray-700 mb-6 leading-relaxed">{{ $application->relevant_experience }}</p>

            <h2 class="font-semibold text-lg mb-3 text-purple-700">Ghi chú thời gian sẵn sàng</h2>
            <p class="text-gray-700 mb-8 leading-relaxed">{{ $application->availability_note ?? 'Không có' }}</p>

            @if($application->status == 'Rejected' && $application->organization_notes)
                <h2 class="font-semibold text-lg mb-3 text-red-700">Ghi chú từ tổ chức</h2>
                <p class="text-red-600 bg-red-50 p-4 rounded-xl">{{ $application->organization_notes }}</p>
            @endif
        </div>

        <div class="p-8 border-t border-purple-100 flex gap-4 justify-center">
            @if($application->status == 'Pending')
                <form method="POST" action="{{ route('volunteer.applications.withdraw', $application->application_id) }}">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-red-700 transition">Rút đơn</button>
                </form>
            @endif
            <a href="{{ route('volunteer.applications.my') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transition">Quay lại</a>
        </div>
    </div>
</div>
@endsection