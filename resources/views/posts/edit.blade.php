@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Edit Post</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Update your post content and settings</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            @include('posts.components.post-form', [
                'action' => route('posts.update', $post->post_id),
                'method' => 'PUT',
                'post' => $post
            ])
        </div>

    </div>
</div>
@endsection