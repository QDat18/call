@extends('layouts.app')

@section('title', 'My Bookmarks')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Saved Posts</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Your bookmarked posts and notes</p>
        </div>

        <div class="space-y-6">
            @forelse($bookmarks as $bookmark)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <a href="{{ route('posts.show', $bookmark->post_id) }}" 
                           class="text-xl font-bold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            {{ $bookmark->post->title ?: Str::limit($bookmark->post->content, 60) }}
                        </a>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            {{ Str::limit($bookmark->post->content, 200) }}
                        </p>
                        <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                            By {{ $bookmark->post->getUserDisplayName() }} • {{ $bookmark->created_at->diffForHumans() }}
                        </div>
                        
                        @if($bookmark->notes)
                        <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded">
                            <p class="text-sm text-gray-700 dark:text-gray-300">📝 {{ $bookmark->notes }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-2 ml-4">
                        <button onclick="removeBookmark({{ $bookmark->post_id }})" 
                                class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition"
                                title="Remove bookmark">
                            <i class="fas fa-bookmark text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                <i class="fas fa-bookmark text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">No bookmarked posts</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Posts you bookmark will appear here for easy access.
                </p>
                <a href="{{ route('posts.index') }}" 
                   class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Explore Posts
                </a>
            </div>
            @endforelse
        </div>

        @if($bookmarks->hasPages())
        <div class="mt-6">
            {{ $bookmarks->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
async function removeBookmark(postId) {
    if (!confirm('Are you sure you want to remove this bookmark?')) return;
    
    try {
        const response = await fetch(`/posts/${postId}/bookmark`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        });

        const data = await response.json();
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        showToast('Failed to remove bookmark', 'error');
    }
}

function showToast(message, type = 'info') {
    // Simple toast notification implementation
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endpush
@endsection