@extends('layouts.volunteer')

@section('title', 'Log Giờ Tình Nguyện')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <nav class="mb-8">
            <a href="{{ route('volunteer.activities.index') }}" class="text-gray-500 hover:text-purple-600 font-medium flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
            </a>
        </nav>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-10 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4 text-white text-2xl shadow-lg border border-white/30">
                        <i class="fas fa-history"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Log Giờ Tình Nguyện</h1>
                    <p class="text-purple-100 text-lg">Ghi nhận đóng góp quý giá của bạn</p>
                </div>
            </div>

            <div class="p-8 sm:p-10">
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-r-lg flex items-center shadow-sm">
                        <i class="fas fa-check-circle text-xl mr-3"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-r-lg flex items-center shadow-sm">
                         <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('volunteer.activities.store') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-2">
                        <label for="opportunity_id" class="block text-sm font-bold text-gray-700">
                            Cơ hội tình nguyện <span class="text-red-500">*</span>
                        </label>
                        
                        @if($opportunities->count() > 0)
                            <div class="relative">
                                <select name="opportunity_id" id="opportunity_id" required
                                        class="block w-full pl-4 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-xl border-2 transition-all hover:border-purple-300 cursor-pointer appearance-none bg-white">
                                    <option value="" disabled selected>-- Chọn cơ hội --</option>
                                    @foreach($opportunities as $opp)
                                        <option value="{{ $opp->opportunity_id }}">
                                            {{ $opp->title }} ({{ $opp->organization_name }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                                <div class="text-yellow-500 text-3xl mb-2"><i class="far fa-frown"></i></div>
                                <h3 class="text-yellow-800 font-bold mb-1">Chưa có cơ hội khả dụng</h3>
                                <p class="text-yellow-700 text-sm mb-4">Bạn cần được chấp nhận vào một cơ hội tình nguyện trước khi log giờ.</p>
                                <a href="{{ route('opportunities.index') }}" class="text-purple-600 font-bold hover:underline text-sm">Tìm cơ hội mới &rarr;</a>
                            </div>
                        @endif
                        @error('opportunity_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="activity_date" class="block text-sm font-bold text-gray-700">
                                Ngày tham gia <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="far fa-calendar text-gray-400"></i>
                                </div>
                                <input type="date" name="activity_date" id="activity_date" required
                                       max="{{ now()->format('Y-m-d') }}"
                                       min="{{ now()->subDays(30)->format('Y-m-d') }}"
                                       class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 sm:text-sm hover:border-purple-300 transition-all">
                            </div>
                            @error('activity_date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="hours_worked" class="block text-sm font-bold text-gray-700">
                                Số giờ làm việc <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="far fa-clock text-gray-400"></i>
                                </div>
                                <input type="number" name="hours_worked" id="hours_worked" step="0.5" min="0.5" max="24" required
                                       placeholder="VD: 3.5"
                                       class="block w-full pl-10 pr-3 py-3 border-2 border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 sm:text-sm hover:border-purple-300 transition-all">
                            </div>
                             <p class="text-xs text-gray-500 text-right">Tối đa 24h/ngày</p>
                            @error('hours_worked') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="activity_description" class="block text-sm font-bold text-gray-700">
                            Mô tả chi tiết <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea name="activity_description" id="activity_description" rows="4" required
                                      placeholder="Mô tả công việc bạn đã thực hiện..."
                                      class="block w-full p-4 border-2 border-gray-300 rounded-xl focus:ring-purple-500 focus:border-purple-500 sm:text-sm hover:border-purple-300 transition-all resize-none"></textarea>
                        </div>
                        <p class="text-xs text-gray-500">Hãy mô tả cụ thể để tổ chức dễ dàng xác nhận cho bạn.</p>
                        @error('activity_description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all transform hover:-translate-y-0.5">
                            Gửi Yêu Cầu Xác Nhận
                        </button>
                        <p class="mt-4 text-center text-sm text-gray-500">
                            <i class="fas fa-shield-alt mr-1"></i> Thông tin sẽ được gửi đến tổ chức để kiểm duyệt
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection