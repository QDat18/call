@extends('layouts.app')

@section('title', 'Volunteer Profile')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4">
        
        <!-- Profile Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
            <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
            <div class="px-6 pb-6">
                <div class="flex items-end -mt-16 mb-4">
                    <img src="{{ Auth::user()->avatar_url ? Storage::url(Auth::user()->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) }}" 
                         alt="{{ Auth::user()->full_name }}"
                         class="w-32 h-32 rounded-full border-4 border-white dark:border-gray-800 object-cover shadow-lg">
                    <div class="ml-6 mb-2 flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ Auth::user()->full_name }}</h1>
                        <p class="text-gray-600 dark:text-gray-400">Volunteer</p>
                        @if(Auth::user()->email_verified_at)
                        <span class="inline-block mt-1 px-2 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 text-xs rounded-full">
                            <i class="fas fa-check-circle mr-1"></i>Verified
                        </span>
                        @endif
                    </div>
                    <div class="mb-2">
                        <a href="{{ route('volunteer.profile.edit') }}" 
                           class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-edit mr-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Volunteer Stats -->
                @if($volunteerProfile)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Volunteer Stats</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $volunteerProfile->total_volunteer_hours }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Hours</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                                {{ $completedActivities ?? 0 }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Activities</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                                {{ number_format($volunteerProfile->volunteer_rating, 1) }}
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Rating</div>
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                @if($volunteerProfile && $volunteerProfile->bio)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">About Me</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $volunteerProfile->bio }}</p>
                </div>
                @endif

                <!-- Skills -->
                @if($volunteerProfile && $volunteerProfile->skills)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Skills & Expertise</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $volunteerProfile->skills) as $skill)
                        <span class="px-4 py-2 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-full text-sm font-medium">
                            {{ trim($skill) }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Availability -->
                @if($volunteerProfile && $volunteerProfile->availability)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Availability</h2>
                    <p class="text-gray-700 dark:text-gray-300">{{ $volunteerProfile->availability }}</p>
                </div>
                @endif
                @endif

                <!-- Personal Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Personal Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Email</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Phone</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ Auth::user()->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Date of Birth</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">
                                {{ Auth::user()->date_of_birth ? Auth::user()->date_of_birth->format('M d, Y') : 'Not provided' }}
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 dark:text-gray-400">Gender</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ ucfirst(Auth::user()->gender ?? 'Not provided') }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="text-sm text-gray-600 dark:text-gray-400">Location</label>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">
                                {{ Auth::user()->city ? Auth::user()->city . ', ' : '' }}{{ Auth::user()->country ?? 'Not provided' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                @if(isset($recentActivities) && $recentActivities->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Recent Activities</h2>
                        <a href="{{ route('volunteer.activities.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 text-sm">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach($recentActivities as $activity)
                        <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $activity->opportunity->title ?? 'Activity' }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $activity->hours_volunteered }} hours • {{ $activity->date->format('M d, Y') }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full 
                                {{ $activity->verification_status === 'Verified' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 
                                   ($activity->verification_status === 'Pending' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : 
                                   'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300') }}">
                                {{ $activity->verification_status }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Account Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Account Settings</h2>
                    <div class="space-y-3">
                        <a href="{{ route('user.change-password') }}" 
                           class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <div class="flex items-center">
                                <i class="fas fa-key text-gray-400 mr-3"></i>
                                <span class="text-gray-900 dark:text-gray-100">Change Password</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>
                        <a href="{{ route('notifications.index') }}" 
                           class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <div class="flex items-center">
                                <i class="fas fa-bell text-gray-400 mr-3"></i>
                                <span class="text-gray-900 dark:text-gray-100">Notification Settings</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Quick Links -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('opportunities.index') }}" 
                           class="block w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-center">
                            <i class="fas fa-search mr-2"></i>Find Opportunities
                        </a>
                        <a href="{{ route('volunteer.applications.my') }}" 
                           class="block w-full px-4 py-2 border border-indigo-600 text-indigo-600 dark:text-indigo-400 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition text-center">
                            <i class="fas fa-file-alt mr-2"></i>My Applications
                        </a>
                        <a href="{{ route('volunteer.favorites.index') }}" 
                           class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition text-center">
                            <i class="fas fa-heart mr-2"></i>Favorites
                        </a>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Account Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Member Since</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Last Login</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Never' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Status</span>
                            <span class="px-2 py-1 {{ Auth::user()->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }} rounded-full text-xs font-medium">
                                {{ Auth::user()->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Public Profile -->
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
                    <h3 class="text-lg font-bold mb-2">Public Profile</h3>
                    <p class="text-sm opacity-90 mb-4">Share your volunteer profile with organizations</p>
                    <a href="{{ route('user.public-profile', Auth::user()->user_id) }}" 
                       target="_blank"
                       class="block w-full px-4 py-2 bg-white text-indigo-600 rounded-lg text-center hover:bg-gray-100 transition font-medium">
                        View Public Profile
                    </a>
                </div>

                <!-- Social Links -->
                @if(Auth::user()->facebook_url || Auth::user()->instagram_url || Auth::user()->linkedin_url)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Social Media</h3>
                    <div class="flex space-x-3">
                        @if(Auth::user()->facebook_url)
                        <a href="{{ Auth::user()->facebook_url }}" target="_blank" 
                           class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-full hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if(Auth::user()->instagram_url)
                        <a href="{{ Auth::user()->instagram_url }}" target="_blank" 
                           class="w-10 h-10 flex items-center justify-center bg-pink-600 text-white rounded-full hover:bg-pink-700 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if(Auth::user()->linkedin_url)
                        <a href="{{ Auth::user()->linkedin_url }}" target="_blank" 
                           class="w-10 h-10 flex items-center justify-center bg-blue-700 text-white rounded-full hover:bg-blue-800 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection