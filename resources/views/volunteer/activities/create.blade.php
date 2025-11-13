{{-- resources/views/volunteer/activities/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Log Giờ Tình Nguyện')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
    .gradient-purple { background: linear-gradient(135deg, #8b5cf6, #6b46c1); }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-indigo-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl p-10 border border-purple-100">
            <a href="{{ route('volunteer.activities.index') }}" 
   class="flex items-center gap-4 p-4 rounded-xl hover:bg-purple-100 transition {{ request()->routeIs('volunteer.activities.*') ? 'bg-purple-100 text-purple-800 font-bold' : 'text-gray-700' }}">
    <i class="fas fa-clock text-2xl"></i>
    <span class="text-lg">Hoạt Động Tình Nguyện</span>
</a>
            <div class="text-center mb-10">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full mx-auto flex items-center justify-center text-white text-5xl mb-6">
                    <i class="fas fa-clock"></i>
                </div>
                <h1 class="text-4xl font-bold text-purple-800">Log Giờ Tình Nguyện</h1>
                <p class="text-gray-600 mt-3 text-lg">Ghi nhận đóng góp của bạn cho cộng đồng</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl mb-8 text-center font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('volunteer.activities.store') }}" class="space-y-8">
                @csrf

                <!-- Opportunity -->
                <div class="relative">
                    <label for="opportunity_id" class="block text-sm font-bold text-purple-700 mb-3">
                        <i class="fas fa-hands-helping mr-2"></i> Cơ hội tình nguyện
                    </label>
                    
                    @if($opportunities->count() > 0)
                        <select name="opportunity_id" id="opportunity_id" required
                                class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none transition text-gray-800 text-lg">
                            <option value="">-- Chọn cơ hội bạn đã tham gia --</option>
                            @foreach($opportunities as $opp)
                                <option value="{{ $opp->opportunity_id }}">
                                    {{ $opp->title }} 
                                    <span class="text-purple-600">({{ $opp->organization_name }})</span>
                                </option>
                            @endforeach
                        </select>
                    @else
                        <div class="bg-yellow-50 border-2 border-yellow-300 rounded-2xl p-6 text-center">
                            <i class="fas fa-exclamation-triangle text-4xl text-yellow-600 mb-4"></i>
                            <p class="text-yellow-800 font-semibold text-lg">Bạn chưa có cơ hội nào được chấp nhận!</p>
                            <p class="text-yellow-700 mt-2">Hãy ứng tuyển và chờ tổ chức duyệt nhé!</p>
                            <a href="{{ route('opportunities.index') }}" 
                               class="mt-4 inline-block bg-yellow-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-yellow-600 transition">
                               Tìm Cơ Hội Ngay
                            </a>
                        </div>
                    @endif

                    @error('opportunity_id')
                        <p class="mt-3 text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Activity Date -->
                <div>
                    <label for="activity_date" class="block text-sm font-bold text-purple-700 mb-3">
                        <i class="fas fa-calendar-alt mr-2"></i> Ngày tham gia
                    </label>
                    <input type="date" name="activity_date" id="activity_date" required
                           max="{{ now()->format('Y-m-d') }}"
                           min="{{ now()->subDays(30)->format('Y-m-d') }}"
                           class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-lg">
                    @error('activity_date')
                        <p class="mt-3 text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hours Worked -->
                <div>
                    <label for="hours_worked" class="block text-sm font-bold text-purple-700 mb-3">
                        <i class="fas fa-hourglass-half mr-2"></i> Số giờ làm việc
                    </label>
                    <input type="number" name="hours_worked" id="hours_worked" step="0.5" min="0.5" max="24" required
                           placeholder="Ví dụ: 3.5" 
                           class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none text-lg">
                    <p class="text-sm text-gray-600 mt-2">Tối đa 24 giờ/ngày</p>
                    @error('hours_worked')
                        <p class="mt-3 text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="activity_description" class="block text-sm font-bold text-purple-700 mb-3">
                        <i class="fas fa-edit mr-2"></i> Mô tả chi tiết
                    </label>
                    <textarea name="activity_description" id="activity_description" rows="5" required
                              placeholder="Hôm nay mình đã giúp dọn rác ở công viên, hướng dẫn trẻ em trồng cây, và phát quà cho các bé khó khăn..."
                              class="w-full p-4 border-2 border-purple-200 rounded-2xl focus:ring-4 focus:ring-purple-300 focus:border-purple-600 outline-none resize-none text-lg"></textarea>
                    @error('activity_description')
                        <p class="mt-3 text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center pt-6">
                    <button type="submit" 
                            class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-12 py-5 rounded-2xl font-bold text-xl shadow-2xl hover:shadow-purple-500/50 transform hover:scale-105 transition duration-300">
                        <i class="fas fa-paper-plane mr-3"></i>
                        Gửi Yêu Cầu Xác Nhận
                    </button>
                </div>
            </form>

            <div class="mt-10 text-center text-gray-500 text-sm">
                <i class="fas fa-info-circle mr-2"></i>
                Yêu cầu của bạn sẽ được tổ chức xem xét trong vòng 48h
            </div>
        </div>
    </div>
</div>
@endsection