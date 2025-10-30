@extends('layouts.app')

@section('title', $user->first_name . ' ' . $user->last_name . ' - Profile')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Profile Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6">
                <!-- Avatar -->
                <div class="relative">
 <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : '/images/default-avatar.png' }}" 
     class="w-40 h-40 rounded-full border-4 border-white dark:border-gray-800 shadow-lg">
                    @if($user->user_type === 'Organization')
                    <div class="absolute -bottom-2 -right-2 bg-green-500 text-white p-1 rounded-full">
                        <i class="fas fa-building text-xs"></i>
                    </div>
                    @elseif($user->user_type === 'Admin')
                    <div class="absolute -bottom-2 -right-2 bg-purple-500 text-white p-1 rounded-full">
                        <i class="fas fa-crown text-xs"></i>
                    </div>
                    @endif
                </div>

                <!-- User Info -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </h1>
                            <div class="flex items-center justify-center md:justify-start space-x-2 mt-1">
                                @if($user->user_type === 'Organization')
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-sm font-medium rounded-full">
                                    <i class="fas fa-building mr-1"></i>Organization
                                </span>
                                @elseif($user->user_type === 'Admin')
                                <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 text-sm font-medium rounded-full">
                                    <i class="fas fa-crown mr-1"></i>Administrator
                                </span>
                                @else
                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm font-medium rounded-full">
                                    <i class="fas fa-user mr-1"></i>Volunteer
                                </span>
                                @endif
                                
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    Joined {{ $user->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center space-x-6 mt-4 md:mt-0">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $user->posts_count }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Posts</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $user->comments_count }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Comments</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    @if($user->bio)
                    <p class="mt-4 text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $user->bio }}
                    </p>
                    @endif

                    <!-- Contact Info (for organizations) -->
                    @if($user->user_type === 'Organization')
                    <div class="mt-4 flex flex-wrap gap-2">
                        @if($user->website)
                        <a href="{{ $user->website }}" target="_blank" 
                           class="inline-flex items-center space-x-1 px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                            <i class="fas fa-globe"></i>
                            <span>Website</span>
                        </a>
                        @endif
                        
                        @if($user->phone)
                        <div class="inline-flex items-center space-x-1 px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm">
                            <i class="fas fa-phone"></i>
                            <span>{{ $user->phone }}</span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content - User's Posts -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Posts Header -->
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                        Recent Posts
                    </h2>
                    
                    <!-- Sort Options -->
                    <div class="flex items-center space-x-2">
                        <select class="text-sm border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg px-3 py-1 focus:ring-2 focus:ring-indigo-500">
                            <option value="newest">Newest First</option>
                            <option value="popular">Most Popular</option>
                        </select>
                    </div>
                </div>

                <!-- Posts List -->
                @forelse($posts as $post)
                    @include('posts.components.post-card', ['post' => $post, 'compact' => true])
                @empty
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-8 text-center">
                        <i class="fas fa-edit text-gray-300 dark:text-gray-600 text-4xl mb-4"></i>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">No posts yet</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ $user->first_name }} hasn't shared any posts with the community yet.
                        </p>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- User Stats Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4">Activity Stats</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Posts</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->posts_count }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Comments</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->comments_count }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Post Likes</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->total_likes }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Member Since</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Most Popular Post -->
                @if($mostPopularPost)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-3">Most Popular Post</h3>
                    <a href="{{ route('posts.show', $mostPopularPost->post_id) }}" 
                       class="block p-3 bg-gray-50 dark:bg-gray-750 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <p class="font-medium text-gray-900 dark:text-gray-100 text-sm line-clamp-2 mb-2">
                            {{ $mostPopularPost->title ?: Str::limit($mostPopularPost->content, 80) }}
                        </p>
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>{{ $mostPopularPost->published_at->diffForHumans() }}</span>
                            <div class="flex items-center space-x-2">
                                <span><i class="fas fa-heart mr-1"></i>{{ $mostPopularPost->likes_count }}</span>
                                <span><i class="fas fa-comment mr-1"></i>{{ $mostPopularPost->comments_count }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endif

                <!-- Recent Activity -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-3">Recent Activity</h3>
                    <div class="space-y-3">
                        @foreach($recentActivity as $activity)
                        <div class="flex items-start space-x-2 text-sm">
                            <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }}-500 mt-0.5"></i>
                            <div>
                                <p class="text-gray-700 dark:text-gray-300">{{ $activity['description'] }}</p>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Report Modal (reuse from posts) -->
@include('posts.components.report-modal')
@endsection

@push('scripts')
<script>
// Additional scripts for user profile page can go here
function followUser(userId) {
    // Implement follow functionality
    console.log('Follow user:', userId);
}

function sendMessage(userId) {
    // Implement message functionality
    console.log('Message user:', userId);
}
</script>
@endpush