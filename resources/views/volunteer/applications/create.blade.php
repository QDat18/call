@extends('layouts.volunteer')

@section('title', 'Ứng Tuyển - ' . $opportunity->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            
            {{-- CỘT TRÁI: THÔNG TIN CƠ HỘI --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-6 border border-white shadow-xl sticky top-24">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 text-xl">
                            <i class="{{ $opportunity->category->icon ?? 'fas fa-hand-holding-heart' }}"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Đang ứng tuyển vào</p>
                            <h2 class="text-lg font-bold text-gray-900 leading-tight line-clamp-2">{{ $opportunity->title }}</h2>
                        </div>
                    </div>
                    
                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-building mt-1 text-gray-400"></i>
                            <div>
                                <p class="text-xs text-gray-500">Tổ chức</p>
                                <p class="font-semibold text-gray-800">{{ $opportunity->organization->organization_name }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt mt-1 text-gray-400"></i>
                            <div>
                                <p class="text-xs text-gray-500">Địa điểm</p>
                                <p class="font-semibold text-gray-800 text-sm">{{ $opportunity->location }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock mt-1 text-gray-400"></i>
                            <div>
                                <p class="text-xs text-gray-500">Thời gian</p>
                                <p class="font-semibold text-gray-800 text-sm">{{ $opportunity->start_date }} - {{ $opportunity->end_date ?? 'Không xác định' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- BOX MẸO ỨNG TUYỂN (ĐÃ FIX LỖI ARRAY) --}}
                    <div class="mt-6 bg-blue-50 p-4 rounded-xl border border-blue-100">
                        <p class="text-xs text-blue-800 font-medium mb-1"><i class="fas fa-lightbulb mr-1"></i> Mẹo ứng tuyển:</p>
                        <div class="text-xs text-blue-600 leading-relaxed">
                            Hãy nêu rõ kinh nghiệm thực tế liên quan đến kỹ năng: 
                            <div class="mt-2 flex flex-wrap gap-1">
                                {{-- Logic kiểm tra: Nếu là mảng thì lặp, nếu là chuỗi thì hiện, nếu null thì hiện mặc định --}}
                                @if(is_array($opportunity->required_skills))
                                    @foreach($opportunity->required_skills as $skill)
                                        <span class="px-2 py-0.5 rounded bg-blue-200 text-blue-800 font-bold border border-blue-300">
                                            {{ trim($skill) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="font-bold">{{ $opportunity->required_skills ?? 'các kỹ năng yêu cầu' }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: FORM ỨNG TUYỂN --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-white/50">
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-8 text-center">
                        <h1 class="text-2xl font-bold text-white mb-2">Đơn Ứng Tuyển</h1>
                        <p class="text-purple-100 text-sm">Hãy cho tổ chức thấy sự nhiệt huyết của bạn!</p>
                    </div>

                    <form method="POST" action="{{ route('volunteer.applications.store') }}" class="p-8 space-y-6">
                        @csrf
                        {{-- INPUT HIDDEN QUAN TRỌNG --}}
                        <input type="hidden" name="opportunity_id" value="{{ $opportunity->opportunity_id }}">
                        <input type="hidden" name="org_id" value="{{ $opportunity->org_id }}">

                        {{-- Motivation Letter --}}
                        <div class="group">
                            <label for="motivation_letter" class="block text-sm font-bold text-gray-700 mb-2">
                                Lý do ứng tuyển <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea name="motivation_letter" id="motivation_letter" rows="5" 
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:bg-white focus:border-purple-500 focus:ring-0 transition duration-200 placeholder-gray-400"
                                    placeholder="Chia sẻ động lực và niềm đam mê của bạn..." required>{{ old('motivation_letter') }}</textarea>
                                <div class="absolute bottom-3 right-3 text-gray-300 group-focus-within:text-purple-400 transition">
                                    <i class="fas fa-pen-fancy"></i>
                                </div>
                            </div>
                            @error('motivation_letter')
                                <p class="mt-2 text-sm text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Relevant Experience --}}
                        <div class="group">
                            <label for="relevant_experience" class="block text-sm font-bold text-gray-700 mb-2">
                                Kinh nghiệm liên quan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea name="relevant_experience" id="relevant_experience" rows="4" 
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-0 transition duration-200 placeholder-gray-400"
                                    placeholder="Bạn đã từng làm các công việc tương tự chưa? Hãy kể ngắn gọn..." required>{{ old('relevant_experience') }}</textarea>
                                <div class="absolute bottom-3 right-3 text-gray-300 group-focus-within:text-blue-400 transition">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                            </div>
                            @error('relevant_experience')
                                <p class="mt-2 text-sm text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Availability Note --}}
                        <div class="group">
                            <label for="availability_note" class="block text-sm font-bold text-gray-700 mb-2">
                                Ghi chú thời gian sẵn sàng
                            </label>
                            <div class="relative">
                                <textarea name="availability_note" id="availability_note" rows="3" 
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:bg-white focus:border-green-500 focus:ring-0 transition duration-200 placeholder-gray-400"
                                    placeholder="Ví dụ: Tôi rảnh vào các buổi chiều cuối tuần...">{{ old('availability_note') }}</textarea>
                                <div class="absolute bottom-3 right-3 text-gray-300 group-focus-within:text-green-400 transition">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            @error('availability_note')
                                <p class="mt-2 text-sm text-red-500 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" class="text-gray-500 hover:text-gray-800 font-medium transition">Hủy bỏ</a>
                            <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-purple-200 hover:shadow-purple-400 hover:-translate-y-1 transition duration-300 flex items-center gap-2">
                                <span>Gửi Đơn Ngay</span>
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection