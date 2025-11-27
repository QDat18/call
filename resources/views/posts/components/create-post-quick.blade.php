<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
    <div class="flex items-start space-x-3">
        {{-- SỬA LẠI LOGIC LẤY ẢNH AVATAR CHUẨN --}}
        <img src="{{ Auth::user()->avatar_url ? asset('storage/' . Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) . '&background=random&color=fff' }}" 
             class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-gray-700"
             alt="Avatar">
             
        <a href="{{ route('posts.create') }}" 
           class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition cursor-pointer text-sm">
            What's on your mind, {{ Auth::user()->first_name }}?
        </a>
    </div>
    <div class="flex items-center justify-around mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('posts.create') }}?type=event" class="flex items-center space-x-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
            <i class="fas fa-calendar text-blue-500"></i>
            <span class="text-sm text-gray-700 dark:text-gray-300">Event</span>
        </a>
        <a href="{{ route('posts.create') }}?type=success_story" class="flex items-center space-x-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
            <i class="fas fa-star text-yellow-500"></i>
            <span class="text-sm text-gray-700 dark:text-gray-300">Story</span>
        </a>
        <a href="{{ route('posts.create') }}?type=question" class="flex items-center space-x-2 px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
            <i class="fas fa-question-circle text-green-500"></i>
            <span class="text-sm text-gray-700 dark:text-gray-300">Ask</span>
        </a>
    </div>
</div>