<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
    <div class="mb-4">
        <i class="fas fa-newspaper text-gray-300 dark:text-gray-600 text-6xl"></i>
    </div>
    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">No posts found</h3>
    <p class="text-gray-600 dark:text-gray-400 mb-6">
        @if(request()->has('search') || request()->has('type') || request()->has('user_type'))
            Try adjusting your filters or search terms
        @else
            Be the first to share something with the community!
        @endif
    </p>
    @auth
    <a href="{{ route('posts.create') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
        <i class="fas fa-plus-circle mr-2"></i>Create First Post
    </a>
    @else
    <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
        <i class="fas fa-user-plus mr-2"></i>Join to Post
    </a>
    @endauth
</div>