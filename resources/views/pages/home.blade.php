{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    
    {{-- HERO SECTION --}}
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-bold mb-6">Connect, Volunteer, Make Impact</h1>
                    <p class="text-xl mb-8 text-indigo-100">Join thousands of volunteers making a difference in Vietnam</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-600 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Get Started
                        </a>
                        <a href="{{ route('opportunities.index') }}" class="px-8 py-4 border-2 border-white text-white rounded-lg font-semibold hover:bg-white/10 transition">
                            Browse Opportunities
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <img src="/images/hero-volunteer.svg" alt="Volunteers" class="w-full">
                </div>
            </div>
        </div>
    </section>

    {{-- QUICK STATS --}}
    <section class="max-w-7xl mx-auto px-4 -mt-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-indigo-600">{{ $stats['total_volunteers'] ?? 0 }}</div>
                <div class="text-gray-600 dark:text-gray-400 mt-2">Active Volunteers</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-green-600">{{ $stats['total_opportunities'] ?? 0 }}</div>
                <div class="text-gray-600 dark:text-gray-400 mt-2">Opportunities</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-purple-600">{{ $stats['total_hours'] ?? 0 }}</div>
                <div class="text-gray-600 dark:text-gray-400 mt-2">Hours Volunteered</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center">
                <div class="text-4xl font-bold text-orange-600">{{ $stats['total_organizations'] ?? 0 }}</div>
                <div class="text-gray-600 dark:text-gray-400 mt-2">Organizations</div>
            </div>
        </div>
    </section>

    {{-- POSTS FEED SECTION --}}
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Community Stories</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Latest updates from our volunteer community</p>
            </div>
            <a href="{{ route('posts.index') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                View All Posts
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Latest Posts (2 columns) --}}
            <div class="lg:col-span-2 space-y-6">
                @forelse($latestPosts->take(5) as $post)
                    @include('posts.components.post-card', ['post' => $post, 'compact' => false])
                @empty
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center">
                        <i class="fas fa-newspaper text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400">No posts yet. Be the first to share!</p>
                    </div>
                @endforelse

                @if($latestPosts->count() > 5)
                <div class="text-center">
                    <a href="{{ route('posts.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                        Load more posts →
                    </a>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                
                {{-- Featured/Pinned Post --}}
                @if($featuredPost)
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border-2 border-yellow-400 dark:border-yellow-600 rounded-lg p-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        <span class="font-bold text-gray-900 dark:text-gray-100">Featured Story</span>
                    </div>
                    <a href="{{ route('posts.show', $featuredPost->post_id) }}">
                        @if($featuredPost->image_url)
                        <img src="{{ $featuredPost->image_url }}" class="w-full h-40 object-cover rounded-lg mb-3">
                        @endif
                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">
                            {{ $featuredPost->title ?: Str::limit($featuredPost->content, 60) }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ Str::limit($featuredPost->content, 120) }}
                        </p>
                    </a>
                </div>
                @endif

                {{-- Trending Topics --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4">🔥 Trending Now</h3>
                    <div class="space-y-3">
                        @foreach($trendingPosts as $trending)
                        <a href="{{ route('posts.show', $trending->post_id) }}" 
                           class="block p-3 hover:bg-gray-50 dark:hover:bg-gray-750 rounded-lg transition">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-2">
                                {{ $trending->title ?: Str::limit($trending->content, 50) }}
                            </p>
                            <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400 mt-2">
                                <span><i class="fas fa-fire text-orange-500 mr-1"></i>{{ $trending->views_count }}</span>
                                <span><i class="fas fa-heart text-red-500 mr-1"></i>{{ $trending->likes_count }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        @auth
                        <a href="{{ route('posts.create') }}" 
                           class="block w-full px-4 py-3 bg-indigo-600 text-white rounded-lg text-center hover:bg-indigo-700 transition">
                            <i class="fas fa-plus-circle mr-2"></i>Share Your Story
                        </a>
                        @else
                        <a href="{{ route('register') }}" 
                           class="block w-full px-4 py-3 bg-indigo-600 text-white rounded-lg text-center hover:bg-indigo-700 transition">
                            Join Community
                        </a>
                        @endauth
                        <a href="{{ route('opportunities.index') }}" 
                           class="block w-full px-4 py-3 border-2 border-indigo-600 text-indigo-600 rounded-lg text-center hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition">
                            Find Opportunities
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- FEATURED OPPORTUNITIES --}}
    <section class="bg-white dark:bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Featured Opportunities</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredOpportunities as $opportunity)
                {{-- Opportunity card component --}}
                @endforeach
            </div>
        </div>
    </section>

    {{-- SUCCESS METRICS --}}
    <section class="max-w-7xl mx-auto px-4 py-16">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl p-12 text-white text-center">
            <h2 class="text-4xl font-bold mb-4">Making Real Impact Together</h2>
            <p class="text-xl text-green-100 mb-8">Join our community of change-makers</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="text-5xl font-bold">{{ $impactStats['lives_touched'] ?? '10K+' }}</div>
                    <div class="text-green-100 mt-2">Lives Touched</div>
                </div>
                <div>
                    <div class="text-5xl font-bold">{{ $impactStats['projects_completed'] ?? '500+' }}</div>
                    <div class="text-green-100 mt-2">Projects Completed</div>
                </div>
                <div>
                    <div class="text-5xl font-bold">{{ $impactStats['communities_served'] ?? '63' }}</div>
                    <div class="text-green-100 mt-2">Communities Served</div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection