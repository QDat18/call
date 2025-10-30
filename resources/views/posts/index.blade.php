@extends('layouts.app')

@section('title', 'Community Feed')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100">Community Feed</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Connect with volunteers and organizations making a difference</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- Left Sidebar - Filters -->
            <div class="lg:col-span-1">
                @include('posts.components.filter-sidebar')
            </div>

            <!-- Main Feed -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Create Post Quick Action (for logged in users) -->
                @auth
                @include('posts.components.create-post-quick')
                @endauth

                <!-- Pinned Posts -->
                @if($pinnedPosts->count() > 0)
                @include('posts.components.pinned-posts', ['pinnedPosts' => $pinnedPosts])
                @endif

                <!-- Posts Feed -->
                @forelse($posts as $post)
                    @include('posts.components.post-card', ['post' => $post])
                @empty
                    @include('posts.components.empty-state')
                @endforelse

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
                @endif

            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                @include('posts.components.trending-sidebar')
                @include('posts.components.top-contributors')
                @include('posts.components.quick-stats')
            </div>

        </div>
    </div>
</div>

<!-- Report Modal -->
@include('posts.components.report-modal')

<!-- Share Modal -->
@include('posts.components.share-modal')

@push('scripts')
{{-- <script src="{{ asset('js/posts.js') }}"></script> --}}
@endpush
@endsection