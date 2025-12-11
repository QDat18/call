@extends('layouts.admin')
@section('title', 'Tạo Chiến dịch mới')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.campaigns.index') }}" 
               class="p-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tạo Chiến dịch Mới</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Khởi tạo một chiến dịch quyên góp ý nghĩa</p>
            </div>
        </div>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 flex items-start shadow-sm">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <h3 class="font-semibold text-red-800 dark:text-red-400 mb-1">Vui lòng kiểm tra lại dữ liệu!</h3>
                <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Thông tin cơ bản
                </h2>
                
                <div class="space-y-5">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Tiêu đề chiến dịch <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required 
                               class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-gray-900 dark:text-white transition shadow-sm placeholder-gray-400"
                               placeholder="VD: Mang áo ấm về bản cao">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Mô tả chi tiết <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="description" rows="8" required 
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-gray-900 dark:text-white transition shadow-sm placeholder-gray-400 leading-relaxed"
                                  placeholder="Mô tả mục đích, hoàn cảnh và ý nghĩa của chiến dịch...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Mục tiêu tài chính & Thời gian
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="target_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Số tiền mục tiêu (VNĐ) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="target_amount" id="target_amount" value="{{ old('target_amount') }}" min="100000" step="100000" required 
                                   class="w-full pl-4 pr-12 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-gray-900 dark:text-white transition shadow-sm"
                                   placeholder="10000000">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₫</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Ngày bắt đầu <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required 
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-gray-900 dark:text-white transition shadow-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Ngày kết thúc <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" required 
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:bg-gray-900 dark:text-white transition shadow-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Image --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Hình ảnh banner <span class="text-red-500">*</span>
                </h2>
                
                <div class="space-y-4">
                    <div class="relative w-full aspect-video bg-gray-50 dark:bg-gray-900 rounded-lg overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600 group flex items-center justify-center hover:border-blue-500 transition-colors cursor-pointer" onclick="document.getElementById('banner_image').click()">
                        <img id="banner-preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        
                        <div id="upload-placeholder" class="text-center p-6">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Click để tải ảnh lên</p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">PNG, JPG, GIF (Max 2MB)</p>
                        </div>
                    </div>
                    
                    <input type="file" name="banner_image" id="banner_image" accept="image/*" class="hidden" required onchange="previewBanner(event)">
                </div>
            </div>

            {{-- Settings --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Cài đặt hiển thị
                </h2>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                    <div>
                        <label for="is_pinned" class="font-medium text-gray-900 dark:text-white text-sm cursor-pointer select-none">Ghim lên Slider</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Hiển thị đầu trang chủ</p>
                    </div>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" name="is_pinned" id="is_pinned" value="1" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                        <label for="is_pinned" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full px-6 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tạo Chiến dịch
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    .toggle-checkbox:checked { right: 0; border-color: #3b82f6; }
    .toggle-checkbox:checked + .toggle-label { background-color: #3b82f6; }
    .toggle-checkbox { right: 0; z-index: 1; border-color: #d1d5db; transition: all 0.3s; top: 0; }
    .toggle-label { width: 2.5rem; height: 1.25rem; background-color: #d1d5db; transition: background-color 0.3s; }
</style>

<script>
function previewBanner(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('banner-preview').src = e.target.result;
            document.getElementById('banner-preview').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection