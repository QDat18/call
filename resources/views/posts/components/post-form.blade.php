<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if($method ?? false)
        @method($method)
    @endif

    <!-- Post Type -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Post Type <span class="text-red-500">*</span>
        </label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @php
                $postTypes = [
                    'general' => ['icon' => 'fas fa-comments', 'label' => 'General', 'color' => 'gray'],
                    'announcement' => ['icon' => 'fas fa-bullhorn', 'label' => 'Announcement', 'color' => 'blue'],
                    'success_story' => ['icon' => 'fas fa-star', 'label' => 'Success Story', 'color' => 'yellow'],
                    'event' => ['icon' => 'fas fa-calendar', 'label' => 'Event', 'color' => 'purple'],
                    'impact_update' => ['icon' => 'fas fa-chart-line', 'label' => 'Impact Update', 'color' => 'green'],
                    'question' => ['icon' => 'fas fa-question-circle', 'label' => 'Question', 'color' => 'indigo'],
                ];
            @endphp
            @foreach($postTypes as $type => $info)
            <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition hover:border-{{ $info['color'] }}-500 dark:hover:border-{{ $info['color'] }}-400
                {{ old('post_type', $post->post_type ?? request('type')) == $type ? 'border-'.$info['color'].'-500 dark:border-'.$info['color'].'-400 bg-'.$info['color'].'-50 dark:bg-'.$info['color'].'-900/20' : 'border-gray-300 dark:border-gray-600' }}">
                <input type="radio" 
                       name="post_type" 
                       value="{{ $type }}" 
                       class="sr-only"
                       {{ old('post_type', $post->post_type ?? request('type')) == $type ? 'checked' : '' }}
                       required>
                <div class="flex items-center space-x-2">
                    <i class="{{ $info['icon'] }} text-{{ $info['color'] }}-600 dark:text-{{ $info['color'] }}-400"></i>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $info['label'] }}</span>
                </div>
            </label>
            @endforeach
        </div>
        @error('post_type')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Title (Optional) -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Title (Optional)
        </label>
        <input type="text" 
               name="title" 
               id="title"
               value="{{ old('title', $post->title ?? '') }}"
               maxlength="200"
               placeholder="Add a catchy title to your post..."
               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
        @error('title')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Content -->
    <div>
        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Content <span class="text-red-500">*</span>
        </label>
        <textarea name="content" 
                  id="content"
                  rows="8"
                  required
                  minlength="10"
                  maxlength="5000"
                  placeholder="Share your thoughts, experiences, or updates with the community..."
                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('content', $post->content ?? '') }}</textarea>
        <div class="flex items-center justify-between mt-2 text-sm text-gray-500 dark:text-gray-400">
            <span>Minimum 10 characters</span>
            <span id="char-count">0 / 5000</span>
        </div>
        @error('content')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Image Upload -->
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Image (Optional)
        </label>
        
        @if(isset($post) && $post->image_url)
        <div class="mb-3 relative">
            <img src="{{ $post->image_url }}" class="w-full h-64 object-cover rounded-lg" id="current-image">
            <label class="absolute top-2 right-2 px-3 py-1 bg-red-600 text-white text-sm rounded-lg cursor-pointer hover:bg-red-700 transition">
                <input type="checkbox" name="remove_image" class="sr-only" onchange="toggleImageRemoval(this)">
                <i class="fas fa-trash mr-1"></i>Remove Image
            </label>
        </div>
        @endif

        <div class="flex items-center justify-center w-full">
            <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-semibold">Click to upload</span> or drag and drop
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">PNG, JPG, GIF up to 5MB</p>
                </div>
                <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(this)">
            </label>
        </div>
        
        <!-- Image Preview -->
        <div id="image-preview" class="mt-3 hidden">
            <img id="preview-img" class="w-full h-64 object-cover rounded-lg">
            <button type="button" onclick="removePreview()" class="mt-2 text-sm text-red-600 hover:text-red-700">
                <i class="fas fa-times mr-1"></i>Remove
            </button>
        </div>
        
        @error('image')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Publishing Options -->
    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center space-x-4">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="allow_comments" value="1" 
                       {{ old('allow_comments', $post->allow_comments ?? true) ? 'checked' : '' }}
                       class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <span class="text-sm text-gray-700 dark:text-gray-300">Allow comments</span>
            </label>
        </div>

        <div class="flex space-x-3">
            <a href="{{ route('posts.index') }}" 
               class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                Cancel
            </a>
            <button type="submit" name="status" value="draft"
                    class="px-6 py-3 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition">
                <i class="fas fa-save mr-2"></i>Save Draft
            </button>
            <button type="submit" name="status" value="published"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-paper-plane mr-2"></i>Publish
            </button>
        </div>
    </div>
</form>

@push('scripts')
<script>
// Character counter
const contentArea = document.getElementById('content');
const charCount = document.getElementById('char-count');

contentArea.addEventListener('input', function() {
    charCount.textContent = this.value.length + ' / 5000';
});

// Trigger on page load
if (contentArea.value) {
    charCount.textContent = contentArea.value.length + ' / 5000';
}

// Image preview
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removePreview() {
    document.getElementById('image').value = '';
    document.getElementById('image-preview').classList.add('hidden');
}

function toggleImageRemoval(checkbox) {
    const currentImage = document.getElementById('current-image');
    if (checkbox.checked) {
        currentImage.style.opacity = '0.3';
    } else {
        currentImage.style.opacity = '1';
    }
}
</script>
@endpush