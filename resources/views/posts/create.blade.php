@extends('layouts.app')

@section('title', 'Create New Post')

@section('content')

    {{-- KIỂM TRA: Nếu chưa xác thực -> Hiện thông báo --}}
    @if(!Auth::user()->is_verified)
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex items-center justify-center px-4">
            <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-red-500 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Tài khoản chưa xác thực</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Bạn cần xác thực tài khoản/email để có thể đăng bài viết mới lên cộng đồng.
                </p>
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 font-medium py-2">
                        Trang chủ
                    </a>
                    {{-- Đã sửa route về 'profile' cho khớp với controller --}}
                    <a href="{{ route('volunteer.profile.profile') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Đến trang cá nhân
                    </a>
                </div>
            </div>
        </div>
    
    {{-- NGƯỢC LẠI: Nếu đã xác thực -> Hiện form đăng bài --}}
    @else
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
            <div class="max-w-4xl mx-auto px-4">
                
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Create New Post</h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">Share your story with the community</p>
                        </div>
                        <a href="{{ route('posts.my-posts') }}" 
                           class="inline-flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to My Posts</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    
                    @if($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <h3 class="text-red-800 dark:text-red-200 font-semibold mb-2">Please fix the following errors:</h3>
                        <ul class="list-disc list-inside text-red-600 dark:text-red-400">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Post Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                
                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-gray-500
                                    {{ old('post_type') == 'general' ? 'border-gray-600 bg-gray-50 dark:bg-gray-900/20' : 'border-gray-200 dark:border-gray-700' }}">
                                    <input type="radio" name="post_type" value="general" class="sr-only peer" 
                                           {{ old('post_type') == 'general' ? 'checked' : '' }} required>
                                    <i class="fas fa-comments text-2xl text-gray-400 peer-checked:text-gray-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 peer-checked:text-gray-900 peer-checked:font-semibold">General</span>
                                </label>

                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-blue-500
                                    {{ old('post_type') == 'announcement' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700' }}">
                                    <input type="radio" name="post_type" value="announcement" class="sr-only peer"
                                           {{ old('post_type') == 'announcement' ? 'checked' : '' }}>
                                    <i class="fas fa-bullhorn text-2xl text-gray-400 peer-checked:text-blue-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 peer-checked:text-blue-900 peer-checked:font-semibold">Announcement</span>
                                </label>

                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-yellow-500
                                    {{ old('post_type') == 'success_story' ? 'border-yellow-600 bg-yellow-50 dark:bg-yellow-900/20' : 'border-gray-200 dark:border-gray-700' }}">
                                    <input type="radio" name="post_type" value="success_story" class="sr-only peer"
                                           {{ old('post_type') == 'success_story' ? 'checked' : '' }}>
                                    <i class="fas fa-star text-2xl text-gray-400 peer-checked:text-yellow-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 peer-checked:text-yellow-900 peer-checked:font-semibold">Success Story</span>
                                </label>

                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-purple-500
                                    {{ old('post_type') == 'event' ? 'border-purple-600 bg-purple-50 dark:bg-purple-900/20' : 'border-gray-200 dark:border-gray-700' }}">
                                    <input type="radio" name="post_type" value="event" class="sr-only peer"
                                           {{ old('post_type') == 'event' ? 'checked' : '' }}>
                                    <i class="fas fa-calendar text-2xl text-gray-400 peer-checked:text-purple-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 peer-checked:text-purple-900 peer-checked:font-semibold">Event</span>
                                </label>

                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-green-500
                                    {{ old('post_type') == 'impact_update' ? 'border-green-600 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-gray-700' }}">
                                    <input type="radio" name="post_type" value="impact_update" class="sr-only peer"
                                           {{ old('post_type') == 'impact_update' ? 'checked' : '' }}>
                                    <i class="fas fa-chart-line text-2xl text-gray-400 peer-checked:text-green-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 peer-checked:text-green-900 peer-checked:font-semibold">Impact Update</span>
                                </label>

                                <label class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-indigo-500
                                    {{ old('post_type') == 'question' ? 'border-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'border-gray-200 dark:border-gray-700' }}">
                                    <input type="radio" name="post_type" value="question" class="sr-only peer"
                                           {{ old('post_type') == 'question' ? 'checked' : '' }}>
                                    <i class="fas fa-question-circle text-2xl text-gray-400 peer-checked:text-indigo-600 mb-2"></i>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 peer-checked:text-indigo-900 peer-checked:font-semibold">Question</span>
                                </label>
                            </div>
                            @error('post_type')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Title (Optional)
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   maxlength="200"
                                   placeholder="Give your post a catchy title..."
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <textarea id="content" 
                                      name="content" 
                                      rows="8"
                                      required
                                      minlength="10"
                                      maxlength="5000"
                                      placeholder="Share your thoughts, experiences, or updates..."
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none">{{ old('content') }}</textarea>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    <span id="char-count">{{ old('content') ? strlen(old('content')) : 0 }}</span>/5000 characters
                                </span>
                                @error('content')
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Photos & Videos
                            </label>
                            
                            <div class="flex items-center justify-center w-full">
                                <label for="media" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:hover:bg-gray-700 dark:border-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-images text-3xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Click to upload multiple images/videos</p>
                                    </div>
                                    <input id="media" name="media[]" type="file" class="hidden" multiple accept="image/*,video/*" onchange="previewMedia(this)">
                                </label>
                            </div>

                            <div id="media-preview-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Post Settings</h3>
                            
                            <div class="space-y-4">
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" 
                                           name="allow_comments" 
                                           value="1"
                                           {{ old('allow_comments', true) ? 'checked' : '' }}
                                           class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    <div>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Allow comments</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Let people comment on your post</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('posts.index') }}" 
                               class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Cancel
                            </a>
                            
                            <div class="flex space-x-3">
                                <button type="submit" 
                                        name="status" 
                                        value="draft"
                                        class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium">
                                    <i class="fas fa-save mr-2"></i>Save as Draft
                                </button>
                                
                                <button type="submit" 
                                        name="status" 
                                        value="published"
                                        class="px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium shadow-sm">
                                    <i class="fas fa-paper-plane mr-2"></i>Publish Post
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
<script>
// Character counter
const contentTextarea = document.getElementById('content');
const charCount = document.getElementById('char-count');

if (contentTextarea) {
    contentTextarea.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });
}

function previewMedia(input) {
    const grid = document.getElementById('media-preview-grid');
    grid.innerHTML = ''; // Clear old previews
    
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative rounded-lg overflow-hidden h-24 border border-gray-200 dark:border-gray-700';
                
                if (file.type.startsWith('image/')) {
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                } else if (file.type.startsWith('video/')) {
                    div.innerHTML = `
                        <video class="w-full h-full object-cover">
                            <source src="${e.target.result}">
                        </video>
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                            <i class="fas fa-play text-white"></i>
                        </div>
                    `;
                }
                grid.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endpush