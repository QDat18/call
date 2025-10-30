<div class="space-y-4">
    
    <!-- Create Post Button -->
    @auth
    <a href="{{ route('posts.create') }}" 
       class="block w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg text-center font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
        <i class="fas fa-plus-circle mr-2"></i>Create Post
    </a>
    @else
    <a href="{{ route('register') }}" 
       class="block w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg text-center font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
        <i class="fas fa-user-plus mr-2"></i>Join Community
    </a>
    @endauth

    <!-- Filters Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
            <i class="fas fa-filter mr-2 text-indigo-600"></i>Filters
        </h3>
        
        <form method="GET" action="{{ route('posts.index') }}" class="space-y-4">
            
            <!-- Post Type -->
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">Post Type</label>
                <select name="type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Types</option>
                    <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>
                        📢 Announcement
                    </option>
                    <option value="success_story" {{ request('type') == 'success_story' ? 'selected' : '' }}>
                        ⭐ Success Story
                    </option>
                    <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>
                        📅 Event
                    </option>
                    <option value="impact_update" {{ request('type') == 'impact_update' ? 'selected' : '' }}>
                        📊 Impact Update
                    </option>
                    <option value="question" {{ request('type') == 'question' ? 'selected' : '' }}>
                        ❓ Question
                    </option>
                    <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>
                        💬 General
                    </option>
                </select>
            </div>

            <!-- User Type -->
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">Posted By</label>
                <select name="user_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Everyone</option>
                    <option value="Organization" {{ request('user_type') == 'Organization' ? 'selected' : '' }}>
                        🏢 Organizations
                    </option>
                    <option value="Volunteer" {{ request('user_type') == 'Volunteer' ? 'selected' : '' }}>
                        👤 Volunteers
                    </option>
                    <option value="Admin" {{ request('user_type') == 'Admin' ? 'selected' : '' }}>
                        👨‍💼 Admins
                    </option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 block">Search</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search posts..."
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Buttons -->
            <div class="space-y-2">
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm font-medium transition">
                    <i class="fas fa-search mr-2"></i>Apply Filters
                </button>
                <a href="{{ route('posts.index') }}" class="block w-full px-4 py-2 text-center border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-sm transition">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- My Activity (if authenticated) -->
    @auth
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
        <h3 class="font-bold text-gray-900 dark:text-gray-100 mb-3">My Activity</h3>
        <div class="space-y-3">
            <a href="{{ route('posts.my-posts') }}" class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                <span><i class="fas fa-edit mr-2"></i>My Posts</span>
                <span class="px-2 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 rounded-full text-xs">
                    {{ Auth::user()->posts()->count() }}
                </span>
            </a>
            <a href="{{ route('posts.bookmarks') }}" class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                <span><i class="fas fa-bookmark mr-2"></i>Bookmarks</span>
                <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 rounded-full text-xs">
                    {{ Auth::user()->postBookmarks()->count() }}
                </span>
            </a>
        </div>
    </div>
    @endauth

</div>  