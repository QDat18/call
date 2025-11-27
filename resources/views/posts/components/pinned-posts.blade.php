<div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/10 dark:to-orange-900/10 border border-amber-200 dark:border-amber-700/50 rounded-lg p-4">
    <h3 class="font-bold text-amber-800 dark:text-amber-200 mb-3 flex items-center text-sm uppercase tracking-wide">
        <i class="fas fa-thumbtack mr-2"></i>Pinned Posts
    </h3>
    <div class="space-y-3">
        @foreach($pinnedPosts as $pinned)
        <a href="{{ route('posts.show', $pinned->post_id) }}" 
           class="block p-3 bg-white dark:bg-gray-800 rounded-lg hover:shadow-md transition border border-amber-100 dark:border-gray-700 group">
            <div class="flex items-start space-x-3">
                <img src="{{ $pinned->getUserAvatar() }}" 
                     class="w-8 h-8 rounded-full flex-shrink-0 object-cover border border-gray-200 dark:border-gray-600">
                
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 dark:text-gray-100 text-sm line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $pinned->title ?: Str::limit($pinned->content, 60) }}
                    </p>
                    <div class="flex items-center mt-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            by {{ $pinned->getUserDisplayName() }}
                        </span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>