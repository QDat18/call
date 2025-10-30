<div class="space-y-4" id="comment-{{ $comment->comment_id }}">
    <div class="flex items-start space-x-3">
        <img src="{{ $comment->user->avatar_url ?? '/images/default-avatar.png' }}" 
             class="w-10 h-10 rounded-full flex-shrink-0">
        
        <div class="flex-1 bg-gray-100 dark:bg-gray-750 rounded-lg p-3">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center space-x-2">
                    <a href="{{ route('user.public-profile', $comment->user_id) }}" 
                       class="font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                        {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                    </a>
                    @if($comment->user->user_type === 'Organization')
                    <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded-full">
                        Organization
                    </span>
                    @elseif($comment->user->user_type === 'Admin')
                    <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 text-xs rounded-full">
                        Admin
                    </span>
                    @endif
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $comment->created_at->diffForHumans() }}
                </span>
            </div>
            
            <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
            
            <div class="flex items-center space-x-4 mt-2 text-sm">
                @auth
                <button onclick="replyToComment({{ $comment->comment_id }}, '{{ $comment->user->first_name }}')" 
                        class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                    <i class="far fa-comment mr-1"></i>Reply
                </button>
                @if($comment->user_id === Auth::id() || Auth::user()->isAdmin())
                <button onclick="deleteComment({{ $comment->comment_id }})" 
                        class="text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                    <i class="fas fa-trash mr-1"></i>Delete
                </button>
                @endif
                @else
                <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600">
                    <i class="far fa-comment mr-1"></i>Reply
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Replies -->
    @if($comment->replies && $comment->replies->count() > 0)
    <div class="ml-12 space-y-4">
        @foreach($comment->replies as $reply)
            @include('posts.components.comment-item', ['comment' => $reply])
        @endforeach
    </div>
    @endif
</div>