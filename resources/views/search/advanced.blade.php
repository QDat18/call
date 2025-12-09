@extends('layouts.app')

@section('title', 'Tìm Kiếm Nâng Cao - Volunteer Connect')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Tìm Kiếm Nâng Cao</h1>
            <p class="text-gray-500">Tùy chỉnh các tiêu chí để tìm được cơ hội chính xác nhất</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            {{-- Decorative Bar --}}
            <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
            
            <form action="{{ route('search') }}" method="GET" class="p-8">
                
                <div class="space-y-6">
                    {{-- Search Text --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Từ khóa tìm kiếm</label>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Ví dụ: Dạy tiếng Anh, Trồng cây, IT Support..." 
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none transition shadow-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Danh mục</label>
                            <select name="category" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories ?? [] as $cat)
                                    <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Location --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Địa điểm</label>
                            <select name="location" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                <option value="">Tất cả địa điểm</option>
                                <option value="Hà Nội">Hà Nội</option>
                                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                <option value="Đà Nẵng">Đà Nẵng</option>
                                <option value="Remote">Làm từ xa</option>
                            </select>
                        </div>

                        {{-- Time Commitment --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Thời gian cam kết</label>
                            <select name="time_commitment" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                <option value="">Bất kỳ</option>
                                <option value="1-2 hours">Ít (1-2 giờ/tuần)</option>
                                <option value="3-5 hours">Trung bình (3-5 giờ/tuần)</option>
                                <option value="Flexible">Linh hoạt</option>
                            </select>
                        </div>

                        {{-- Experience --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Yêu cầu kinh nghiệm</label>
                            <select name="experience_needed" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                <option value="">Bất kỳ</option>
                                <option value="No experience">Không yêu cầu</option>
                                <option value="Some experience">Có chút kinh nghiệm</option>
                                <option value="Experienced">Đã có kinh nghiệm</option>
                            </select>
                        </div>
                    </div>

                    {{-- Sorting Preference --}}
                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Ưu tiên hiển thị</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" name="sort" value="latest" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" checked>
                                <span class="ml-2 text-gray-700 group-hover:text-indigo-600 transition">Mới nhất</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" name="sort" value="popular" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <span class="ml-2 text-gray-700 group-hover:text-indigo-600 transition">Phổ biến nhất</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" name="sort" value="deadline" class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <span class="ml-2 text-gray-700 group-hover:text-indigo-600 transition">Sắp hết hạn</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-4">
                    <a href="{{ route('opportunities.index') }}" class="px-6 py-3 text-gray-600 font-bold hover:text-gray-900 transition text-sm">
                        Hủy bỏ
                    </a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5">
                        <i class="fas fa-search mr-2"></i> Tìm Kiếm Ngay
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection