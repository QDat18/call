@extends('layouts.app')

@section('title', 'My Posts')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">My Posts</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Manage all your posts in one place</p>
                </div>
                <a href="{{ route('posts.create') }}" 
                   class="inline-flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Create New Post</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Posts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-indigo-600 dark:text-indigo-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Published</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['published'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Drafts</p>
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['draft'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-yellow-600 dark:text-yellow-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Views</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_views'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-eye text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Tabs -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex space-x-2">
                    <a href="{{ route('posts.my-posts', ['status' => 'all']) }}" 
                       class="px-4 py-2 rounded-lg transition {{ request('status', 'all') == 'all' ? 'bg-indigo-100 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        All Posts
                    </a>
                    <a href="{{ route('posts.my-posts', ['status' => 'published']) }}" 
                       class="px-4 py-2 rounded-lg transition {{ request('status') == 'published' ? 'bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Published
                    </a>
                    <a href="{{ route('posts.my-posts', ['status' => 'draft']) }}" 
                       class="px-4 py-2 rounded-lg transition {{ request('status') == 'draft' ? 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Drafts
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                            onchange="window.location.href = this.value">
                        <option value="{{ route('posts.my-posts', array_merge(request()->all(), ['sort' => 'newest'])) }}" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="{{ route('posts.my-posts', array_merge(request()->all(), ['sort' => 'oldest'])) }}" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="{{ route('posts.my-posts', array_merge(request()->all(), ['sort' => 'most_viewed'])) }}" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Most Viewed</option>
                        <option value="{{ route('posts.my-posts', array_merge(request()->all(), ['sort' => 'most_liked'])) }}" {{ request('sort') == 'most_liked' ? 'selected' : '' }}>Most Liked</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Posts List -->
        <div class="space-y-4">
            @forelse($posts as $post)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <!-- Post Type Badge & Status -->
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="inline-flex items-center space-x-1 px-2 py-1 bg-{{ $post->getTypeColor() }}-100 dark:bg-{{ $post->getTypeColor() }}-900/20 text-{{ $post->getTypeColor() }}-600 dark:text-{{ $post->getTypeColor() }}-400 rounded text-xs font-medium">
                                    <i class="{{ $post->getTypeIcon() }} text-xs"></i>
                                    <span>{{ $post->getTypeLabel() }}</span>
                                </span>

                                @if($post->status === 'draft')
                                <span class="inline-flex items-center px-2 py-1 bg-yellow-100 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 rounded text-xs font-medium">
                                    <i class="fas fa-edit text-xs mr-1"></i>Draft
                                </span>
                                @elseif($post->status === 'published')
                                <span class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded text-xs font-medium">
                                    <i class="fas fa-check-circle text-xs mr-1"></i>Published
                                </span>
                                @endif

                                @if($post->is_pinned)
                                <span class="inline-flex items-center px-2 py-1 bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 rounded text-xs font-medium">
                                    <i class="fas fa-thumbtack text-xs mr-1"></i>Pinned
                                </span>
                                @endif
                            </div>

                            <!-- Title or Content Preview -->
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                @if($post->title)
                                    {{ $post->title }}
                                @else
                                    {{ Str::limit($post->content, 60) }}
                                @endif
                            </h3>

                            <!-- Content Snippet -->
                            @if($post->title)
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                {{ Str::limit($post->content, 150) }}
                            </p>
                            @endif

                            <!-- Stats -->
                            <div class="flex items-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ $post->views_count }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-heart"></i>
                                    <span>{{ $post->likes_count }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-comment"></i>
                                    <span>{{ $post->comments_count }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Post Thumbnail (if has image) -->
                        @if($post->image_url)
                        <div class="ml-4 flex-shrink-0">
                            <img src="{{ $post->image_url }}" 
                                 alt="Post thumbnail" 
                                 class="w-24 h-24 object-cover rounded-lg">
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions Footer -->
                <div class="px-6 py-3 bg-gray-50 dark:bg-gray-750 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('posts.show', $post->post_id) }}" 
                           class="inline-flex items-center px-3 py-1.5 text-sm text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition">
                            <i class="fas fa-eye mr-1.5"></i>View
                        </a>

                        <a href="{{ route('posts.edit', $post->post_id) }}" 
                           class="inline-flex items-center px-3 py-1.5 text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                            <i class="fas fa-edit mr-1.5"></i>Edit
                        </a>

                        @if($post->status === 'draft')
                        <form action="{{ route('posts.publish', $post->post_id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="inline-flex items-center px-3 py-1.5 text-sm text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition">
                                <i class="fas fa-paper-plane mr-1.5"></i>Publish
                            </button>
                        </form>
                        @endif
                    </div>

                    <form action="{{ route('posts.destroy', $post->post_id) }}" 
                          method="POST" 
                          class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-1.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                            <i class="fas fa-trash mr-1.5"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                <i class="fas fa-file-alt text-gray-300 dark:text-gray-600 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">No posts yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Start sharing your stories and experiences with the community</p>
                <a href="{{ route('posts.create') }}" 
                   class="inline-flex items-center space-x-2 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-plus"></i>
                    <span>Create Your First Post</span>
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
// Auto-hide success messages after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>
@endpush
@endsection