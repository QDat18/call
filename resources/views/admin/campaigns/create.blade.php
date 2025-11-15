@extends('layouts.admin')
@section('title', 'Tạo Chiến dịch mới')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center space-x-4 mb-4">
            <a href="{{ route('admin.campaigns.index') }}" 
               class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Tạo Chiến dịch mới</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Điền thông tin để tạo chiến dịch quyên góp</p>
            </div>
        </div>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="font-semibold text-red-800 dark:text-red-400 mb-2">Có lỗi xảy ra!</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Thông tin cơ bản</h2>
            
            <div class="space-y-5">
                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tiêu đề chiến dịch <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-900 dark:text-white transition"
                           placeholder="Vd: Hỗ trợ học sinh vùng cao">
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mô tả chi tiết <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="6" 
                              required 
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-900 dark:text-white transition"
                              placeholder="Mô tả về mục đích, đối tượng hưởng lợi...">{{ old('description') }}</textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mô tả càng chi tiết càng thu hút nhiều người quyên góp</p>
                </div>

                {{-- Amount & Date --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="target_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mục tiêu (VNĐ) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="target_amount" 
                               id="target_amount" 
                               value="{{ old('target_amount') }}" 
                               min="1000000" 
                               step="100000" 
                               required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-900 dark:text-white transition"
                               placeholder="10000000">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tối thiểu 1.000.000 VNĐ</p>
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Ngày kết thúc <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               name="end_date" 
                               id="end_date" 
                               value="{{ old('end_date') }}" 
                               required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-900 dark:text-white transition">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Hình ảnh & Cài đặt</h2>
            
            <div class="space-y-5">
                {{-- Banner --}}
                <div>
                    <label for="banner_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Ảnh bìa (Banner) <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-blue-500 transition">
                        <input type="file" 
                               name="banner_image" 
                               id="banner_image" 
                               accept="image/*" 
                               required 
                               class="hidden"
                               onchange="previewImage(event)">
                        <label for="banner_image" class="cursor-pointer">
                            <div id="preview-container" class="hidden mb-4">
                                <img id="preview-image" class="max-h-64 mx-auto rounded-lg shadow-md">
                            </div>
                            <div id="upload-prompt">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Click để chọn ảnh</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">PNG, JPG, GIF (Tối đa 2MB)</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Pin --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <input type="checkbox" 
                               name="is_pinned" 
                               id="is_pinned" 
                               value="1" 
                               class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <div class="ml-3">
                            <label for="is_pinned" class="font-medium text-gray-900 dark:text-white cursor-pointer">
                                Ghim chiến dịch lên Slider đầu trang
                            </label>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                Chiến dịch sẽ được hiển thị nổi bật. Các chiến dịch đang ghim khác sẽ tự động bị hủy ghim.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.campaigns.index') }}" 
               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Hủy
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Tạo Chiến dịch
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
            document.getElementById('upload-prompt').classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
