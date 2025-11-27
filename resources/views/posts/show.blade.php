@extends('layouts.app')

@section('title', $post->title ?: 'Chi tiết bài viết')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-4">
    <div class="max-w-2xl mx-auto px-4">
        
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('posts.index') }}" 
               class="inline-flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition">
                <i class="fas fa-arrow-left"></i>
                <span class="text-[15px] font-semibold">Back to Feed</span>
            </a>
        </div>

        {{-- Main Post Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm mb-4">
            
            {{-- Header --}}
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('user.public-profile', $post->user_id) }}" class="flex-shrink-0">
                            <img src="{{ $post->getUserAvatar() }}" 
                                 class="w-10 h-10 rounded-full object-cover">
                        </a>
                        <div>
                            <a href="{{ route('user.public-profile', $post->user_id) }}" 
                               class="font-semibold text-[15px] text-gray-900 dark:text-gray-100 hover:underline block">
                                {{ $post->getUserDisplayName() }}
                            </a>
                            <div class="flex items-center space-x-1 text-[13px] text-gray-500 dark:text-gray-400">
                                <span>{{ $post->published_at->diffForHumans() }}</span>
                                <span>·</span>
                                <i class="fas fa-globe-americas text-[11px]"></i>
                            </div>
                        </div>
                    </div>

                    <button class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 transition">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
                </div>

                {{-- Content --}}
                <div class="mt-4">
                    @if($post->title)
                        <h1 class="text-[20px] font-semibold text-gray-900 dark:text-white mb-2">{{ $post->title }}</h1>
                    @endif

                    <div class="text-[15px] text-gray-900 dark:text-gray-100 whitespace-pre-line leading-relaxed">
                        {{ $post->content }}
                    </div>
                </div>
            </div>

            {{-- Image --}}
            @if($post->image_url)
            <div class="border-t border-b border-gray-200 dark:border-gray-700">
                <img src="{{ $post->image_url }}" alt="Post image" class="w-full object-cover">
            </div>
            @endif

            {{-- Stats Bar --}}
            <div class="px-4 py-2 flex items-center justify-between text-[15px] text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-1">
                    @if($post->likes_count > 0)
                        <div class="flex items-center -space-x-1">
                            <div class="w-[18px] h-[18px] rounded-full bg-blue-500 flex items-center justify-center">
                                <i class="fas fa-thumbs-up text-white text-[10px]"></i>
                            </div>
                            <div class="w-[18px] h-[18px] rounded-full bg-red-500 flex items-center justify-center">
                                <i class="fas fa-heart text-white text-[10px]"></i>
                            </div>
                        </div>
                        <span class="ml-2">{{ $post->likes_count }}</span>
                    @endif
                </div>
                
                <div class="flex items-center space-x-3">
                    <span>{{ $post->comments_count }} comments</span>
                    <span>{{ number_format($post->views_count) }} views</span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="px-2 py-1">
                <div class="flex items-center justify-around">
                    <button onclick="toggleLike({{ $post->post_id }})" 
                            class="flex-1 flex items-center justify-center space-x-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ $post->isLikedByUser(Auth::id()) ? 'text-blue-600' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="{{ $post->isLikedByUser(Auth::id()) ? 'fas' : 'far' }} fa-thumbs-up text-xl"></i>
                        <span class="font-semibold text-[15px]">Like</span>
                    </button>

                    <button class="flex-1 flex items-center justify-center space-x-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition text-gray-600 dark:text-gray-400">
                        <i class="far fa-comment text-xl"></i>
                        <span class="font-semibold text-[15px]">Comment</span>
                    </button>

                    <button onclick="toggleBookmark({{ $post->post_id }})" 
                            class="flex-1 flex items-center justify-center space-x-2 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ $post->isBookmarkedByUser(Auth::id()) ? 'text-yellow-600' : 'text-gray-600 dark:text-gray-400' }}">
                        <i class="{{ $post->isBookmarkedByUser(Auth::id()) ? 'fas' : 'far' }} fa-bookmark text-xl"></i>
                        <span class="font-semibold text-[15px]">Save</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Comments Section --}}
        @if($post->allow_comments)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4">
            
            @auth
            {{-- Comment Form --}}
            <div class="mb-6">
                <form action="{{ route('posts.comment', $post->post_id) }}" method="POST" id="comment-form">
                    @csrf
                    <input type="hidden" name="parent_id" id="parent_id_input">

                    {{-- Reply Indicator --}}
                    <div id="reply-indicator" class="hidden mb-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-2 rounded-lg text-[13px] flex justify-between items-center">
                        <span>Replying to <b id="reply-to-username"></b></span>
                        <button type="button" onclick="cancelReply()" class="hover:text-blue-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="flex gap-2">
                        <img src="{{ Auth::user()->avatar_url ? asset('storage/'.Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->first_name).'&background=random' }}" 
                             class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                        
                        <div class="flex-1 flex items-center bg-gray-100 dark:bg-gray-700 rounded-full px-4 py-2">
                            <input type="text" 
                                   name="content" 
                                   id="comment-content"
                                   class="flex-1 bg-transparent border-0 focus:ring-0 text-[15px] text-gray-900 dark:text-gray-100 placeholder-gray-500"
                                   placeholder="Write a comment...">
                            <button type="submit" class="ml-2 text-blue-600 hover:text-blue-700 transition">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            @else
            <div class="mb-6 text-center py-4">
                <p class="text-gray-600 dark:text-gray-400 text-[15px]">
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Log in</a> to comment
                </p>
            </div>
            @endauth

            {{-- Comments List --}}
            <div class="space-y-1">
                @forelse($post->comments as $comment)
                    @include('posts.components.comment-item', ['comment' => $comment, 'level' => 0])
                @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <i class="far fa-comments text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-[15px]">No comments yet. Be the first to comment!</p>
                    </div>
                @endforelse
            </div>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    function replyToComment(commentId, username) {
        const parentInput = document.getElementById('parent_id_input');
        const replyIndicator = document.getElementById('reply-indicator');
        const replyUsername = document.getElementById('reply-to-username');
        const input = document.getElementById('comment-content');

        if (parentInput && input) {
            parentInput.value = commentId;
            replyUsername.textContent = username;
            replyIndicator.classList.remove('hidden');
            input.focus();
            input.placeholder = "Write a reply...";
            input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function cancelReply() {
        document.getElementById('parent_id_input').value = '';
        document.getElementById('reply-indicator').classList.add('hidden');
        const input = document.getElementById('comment-content');
        input.placeholder = "Write a comment...";
        input.value = '';
    }

    async function toggleLike(postId) {
        try {
            const response = await fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            });
            if ((await response.json()).success) location.reload();
        } catch (error) { console.error(error); }
    }

    async function toggleBookmark(postId) {
        try {
            const response = await fetch(`/posts/${postId}/bookmark`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            });
            if ((await response.json()).success) location.reload();
        } catch (error) { console.error(error); }
    }
</script>
@endpush
@endsection