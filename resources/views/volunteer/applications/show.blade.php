@extends('layouts.volunteer')

@section('title', 'Chi Tiết Đơn Ứng Tuyển')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12 px-4">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-purple-100">
        <div class="p-8 border-b border-purple-100">
            <h1 class="text-3xl font-bold mb-4 text-purple-800">{{ $application->opportunity->title }}</h1>
            <div class="flex items-center gap-6 text-sm text-gray-600">
                <span>Status: <span class="font-medium @if($application->status == 'Pending') text-yellow-600 @elseif($application->status == 'Under Review') text-blue-600 @elseif($application->status == 'Accepted') text-green-600 @elseif($application->status == 'Rejected') text-red-600 @else text-gray-600 @endif">{{ $application->status }}</span></span>
                <div>
                    <p class="text-sm text-gray-600">Applied Date</p>
                    <p class="font-semibold text-gray-800">
                        {{ $application->applied_date->format('M d, Y') }}  <!-- Sửa format ưu tiên theo organization -->
                        <span class="text-sm text-gray-500">({{ $application->applied_date->diffForHumans() }})</span>  <!-- Thêm như organization -->
                    </p>
                </div>
                @if($application->reviewed_date)
                    <div>
                        <p class="text-sm text-gray-600">Reviewed Date</p>
                        <p class="font-semibold text-gray-800">{{ $application->reviewed_date->format('M d, Y') }}</p>  <!-- Đồng bộ format -->
                    </div>
                @endif
            </div>
        </div>

        <div class="p-8">
            <h2 class="font-semibold text-lg mb-3 text-purple-700">Tổ chức</h2>
            <p class="text-gray-700 mb-6">{{ $application->opportunity->organization->organization_name }}</p>  <!-- Ưu tiên tên từ organization -->

            <h2 class="font-semibold text-lg mb-3 text-purple-700">Lý do ứng tuyển</h2>
            <div class="text-gray-700 whitespace-pre-line mb-6">{{ $application->motivation_letter }}</div>  <!-- Giữ như organization -->

            <h2 class="font-semibold text-lg mb-3 text-purple-700">Kinh nghiệm liên quan</h2>
            <div class="text-gray-700 whitespace-pre-line mb-6">{{ $application->relevant_experience }}</div>

            <h2 class="font-semibold text-lg mb-3 text-purple-700">Ghi chú thời gian sẵn sàng</h2>
            <div class="text-gray-700 whitespace-pre-line mb-8">{{ $application->availability_note }}</div>

            @if($application->organization_notes)  <!-- Ưu tiên hiển thị notes từ organization nếu có -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold text-yellow-900 mb-4">Internal Notes từ Tổ chức</h2>
                    <div class="text-yellow-800 whitespace-pre-line">{{ $application->organization_notes }}</div>
                </div>
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