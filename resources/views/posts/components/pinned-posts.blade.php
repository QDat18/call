<div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border-2 border-yellow-400 dark:border-yellow-600 rounded-lg p-4">
    <h3 class="font-bold text-yellow-900 dark:text-yellow-100 mb-3 flex items-center">
        <i class="fas fa-thumbtack mr-2"></i>Pinned Posts
    </h3>
    <div class="space-y-2">
        @foreach($pinnedPosts as $pinned)
        <a href="{{ route('posts.show', $pinned->post_id) }}" 
           class="block p-3 bg-white dark:bg-gray-800 rounded-lg hover:shadow-md transition">
            <div class="flex items-start space-x-3">
                <img src="{{ $pinned->getUserAvatar() }}" class="w-8 h-8 rounded-full flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 dark:text-gray-100 text-sm line-clamp-2">
                        {{ $pinned->title ?: Str::limit($pinned->content, 60) }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        by {{ $pinned->getUserDisplayName() }}
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>