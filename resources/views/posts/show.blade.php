@extends('layouts.app')

@section('title', $post->title ?: 'Post Details')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('posts.index') }}" 
               class="inline-flex items-center space-x-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Feed</span>
            </a>
        </div>

        <!-- Main Post Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
            
            <!-- Post Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $post->getUserAvatar() }}" 
                             class="w-12 h-12 rounded-full">
                        <div>
                            <a href="{{ route('user.public-profile', $post->user_id) }}" 
                               class="font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                                {{ $post->getUserDisplayName() }}
                            </a>
                            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                <span>{{ $post->published_at->diffForHumans() }}</span>
                                {!! $post->getUserBadge() !!}
                            </div>
                        </div>
                    </div>

                    <!-- Post Actions Dropdown -->
                    @auth
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" 
                                @click="open = !open"
                                class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-10">
                            
                            @if(Auth::id() === $post->user_id)
                            <a href="{{ route('posts.edit', $post->post_id) }}" 
                               class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </a>
                            <button type="button" 
                                    onclick="if(confirm('Delete this post?')) document.getElementById('delete-post-form').submit()"
                                    class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-trash"></i>
                                <span>Delete</span>
                            </button>
                            <form id="delete-post-form" action="{{ route('posts.destroy', $post->post_id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            @else
                            <button type="button" 
                                    onclick="alert('Report feature coming soon')"
                                    class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-flag"></i>
                                <span>Report</span>
                            </button>
                            @endif
                            
                            <button type="button" 
                                    onclick="sharePost({{ $post->post_id }})"
                                    class="flex items-center space-x-2 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-share"></i>
                                <span>Share</span>
                            </button>
                        </div>
                    </div>
                    @endauth
                </div>

                <!-- Post Type Badge -->
                <div class="inline-flex items-center space-x-2 px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full text-sm font-medium">
                    <i class="{{ $post->getTypeIcon() }}"></i>
                    <span>{{ $post->getTypeLabel() }}</span>
                </div>
            </div>

            <!-- Post Content -->
            <div class="p-6">
                @if($post->title)
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    {{ $post->title }}
                </h1>
                @endif

                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">
                        {{ $post->content }}
                    </p>
                </div>

                <!-- Post Image -->
                @if($post->image_url)
                <div class="mt-6">
                    <img src="{{ $post->image_url }}" 
                         alt="Post image" 
                         class="w-full rounded-lg shadow-sm max-w-2xl mx-auto">
                </div>
                @endif
            </div>

            <!-- Post Stats & Actions -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6 text-sm text-gray-600 dark:text-gray-400">
                        <span class="flex items-center space-x-1">
                            <i class="fas fa-eye"></i>
                            <span>{{ $post->views_count }} views</span>
                        </span>
                        <span class="flex items-center space-x-1">
                            <i class="fas fa-heart"></i>
                            <span id="likes-count">{{ $post->likes_count }} likes</span>
                        </span>
                        <span class="flex items-center space-x-1">
                            <i class="fas fa-comment"></i>
                            <span>{{ $post->comments_count }} comments</span>
                        </span>
                    </div>

                    <div class="flex items-center space-x-3">
                        @auth
                        <!-- Like Button -->
                        <button type="button" 
                                id="like-btn"
                                onclick="toggleLike({{ $post->post_id }})"
                                class="flex items-center space-x-1 px-3 py-2 rounded-lg transition {{ $post->isLikedByUser(Auth::id()) ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="{{ $post->isLikedByUser(Auth::id()) ? 'fas' : 'far' }} fa-heart"></i>
                            <span>Like</span>
                        </button>

                        <!-- Bookmark Button -->
                        <button type="button" 
                                id="bookmark-btn"
                                onclick="toggleBookmark({{ $post->post_id }})"
                                class="flex items-center space-x-1 px-3 py-2 rounded-lg transition {{ $post->isBookmarkedByUser(Auth::id()) ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="{{ $post->isBookmarkedByUser(Auth::id()) ? 'fas' : 'far' }} fa-bookmark"></i>
                            <span>Save</span>
                        </button>
                        @else
                        <a href="{{ route('login') }}" 
                           class="flex items-center space-x-1 px-3 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                            <i class="far fa-heart"></i>
                            <span>Like</span>
                        </a>
                        <a href="{{ route('login') }}" 
                           class="flex items-center space-x-1 px-3 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                            <i class="far fa-bookmark"></i>
                            <span>Save</span>
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        @if($post->allow_comments)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                Comments ({{ $post->comments_count }})
            </h3>

            <!-- Add Comment Form - SỬA ĐÂY -->
            @auth
            <form action="{{ route('posts.comment', $post->post_id) }}" method="POST" class="mb-6">
                @csrf
                <div class="flex items-start space-x-3">
                    <img src="{{ Auth::user()->avatar_url ?? '/images/default-avatar.png' }}" 
                         class="w-10 h-10 rounded-full flex-shrink-0">
                    <div class="flex-1">
                        <textarea name="content" 
                                  rows="3"
                                  required
                                  minlength="1"
                                  maxlength="1000"
                                  placeholder="Share your thoughts..."
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"></textarea>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Max 1000 characters
                            </span>
                            <button type="submit" 
                                    class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-paper-plane mr-2"></i>Post Comment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <div class="bg-gray-50 dark:bg-gray-750 rounded-lg p-4 text-center mb-6">
                <p class="text-gray-600 dark:text-gray-400 mb-2">
                    Please <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">login</a> to join the conversation.
                </p>
            </div>
            @endauth

            <!-- Comments List -->
            <div class="space-y-6" id="comments-section">
                @forelse($post->comments as $comment)
                    @include('posts.components.comment-item', ['comment' => $comment])
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-comments text-gray-300 dark:text-gray-600 text-4xl mb-3"></i>
                        <p class="text-gray-600 dark:text-gray-400">No comments yet. Be the first to share your thoughts!</p>
                    </div>
                @endforelse
            </div>
        </div>
        @else
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 text-center">
            <i class="fas fa-comment-slash text-gray-300 dark:text-gray-600 text-4xl mb-3"></i>
            <p class="text-gray-600 dark:text-gray-400">Comments are disabled for this post.</p>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
// Like functionality
async function toggleLike(postId) {
    try {
        const response = await fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Bookmark functionality
async function toggleBookmark(postId) {
    try {
        const response = await fetch(`/posts/${postId}/bookmark`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            location.reload();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// Share functionality
function sharePost(postId) {
    const url = `${window.location.origin}/posts/${postId}`;
    
    if (navigator.share) {
        navigator.share({
            title: '{{ $post->title }}',
            url: url
        });
    } else {
        navigator.clipboard.writeText(url);
        alert('Link copied to clipboard!');
    }
}
</script>
@endpush
@endsection