{{-- resources/views/posts/components/post-card.blade.php --}}
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
    
    {{-- Header --}}
    <div class="p-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <img src="{{ $post->getUserAvatar() }}" class="w-10 h-10 rounded-full">
            <div>
                <a href="{{ route('user.public-profile', $post->user_id) }}" class="font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                    {{ $post->getUserDisplayName() }}
                </a>
                <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                    <span>{{ $post->published_at->diffForHumans() }}</span>
                    {!! $post->getUserBadge() !!}
                </div>
            </div>
        </div>
        
        {{-- Post Actions Dropdown --}}
        <div class="relative">
            <button type="button" 
                    class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                    onclick="togglePostActions({{ $post->post_id }})">
                <i class="fas fa-ellipsis-h"></i>
            </button>
            
            {{-- Actions Dropdown Menu --}}
            <div id="post-actions-{{ $post->post_id }}" 
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-10 hidden">
                <button type="button" 
                        onclick="openShareModal({{ $post->post_id }}, '{{ addslashes($post->title) }}')"
                        class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-share"></i>
                    <span>Share</span>
                </button>
                
                @auth
                @if(Auth::id() !== $post->user_id)
                <button type="button" 
                        onclick="openReportModal({{ $post->post_id }})"
                        class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-flag"></i>
                    <span>Report</span>
                </button>
                @endif
                
                {{-- Bookmark option --}}
                <button type="button" 
                        onclick="toggleBookmark({{ $post->post_id }})"
                        class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="far fa-bookmark"></i>
                    <span>Save</span>
                </button>
                @endauth
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="px-4 pb-4">
        @if($post->title)
        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">{{ $post->title }}</h3>
        @endif
        <p class="text-gray-700 dark:text-gray-300">
            {{ Str::limit($post->content, $compact ?? false ? 150 : 300) }}
        </p>
    </div>

    {{-- Image --}}
    @if($post->image_url)
    <a href="{{ route('posts.show', $post->post_id) }}">
        <img src="{{ $post->image_url }}" class="w-full h-64 object-cover hover:opacity-95 transition">
    </a>
    @endif

    {{-- Stats --}}
    <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
        <div class="flex space-x-4">
            <span><i class="fas fa-heart text-red-500 mr-1"></i>{{ $post->likes_count }}</span>
            <span><i class="fas fa-comment mr-1"></i>{{ $post->comments_count }}</span>
        </div>
        <a href="{{ route('posts.show', $post->post_id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
            Read more →
        </a>
    </div>
</div>

<script>
function togglePostActions(postId) {
    const menu = document.getElementById(`post-actions-${postId}`);
    menu.classList.toggle('hidden');
    
    // Close other open menus
    document.querySelectorAll('[id^="post-actions-"]').forEach(otherMenu => {
        if (otherMenu.id !== `post-actions-${postId}`) {
            otherMenu.classList.add('hidden');
        }
    });
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('[onclick*="togglePostActions"]')) {
        document.querySelectorAll('[id^="post-actions-"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>