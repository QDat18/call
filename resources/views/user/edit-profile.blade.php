@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Edit Profile</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Update your profile information and settings</p>
                </div>
                <a href="{{ route('profile') }}" 
                   class="inline-flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Profile</span>
                </a>
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Picture Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Profile Picture</h2>
                
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        <img id="avatar-preview" 
                             src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) }}" 
                             class="w-24 h-24 rounded-full object-cover border-4 border-gray-200 dark:border-gray-700"
                             alt="Profile picture">
                        <label for="avatar" class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full cursor-pointer hover:bg-indigo-700 transition shadow-lg">
                            <i class="fas fa-camera text-sm"></i>
                            <input type="file" 
                                   id="avatar" 
                                   name="avatar" 
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewAvatar(this)">
                        </label>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Change your avatar</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">JPG, PNG or GIF. Max size 2MB.</p>
                        @error('avatar')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="first_name" 
                               name="first_name" 
                               value="{{ old('first_name', Auth::user()->first_name) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="last_name" 
                               name="last_name" 
                               value="{{ old('last_name', Auth::user()->last_name) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', Auth::user()->email) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Phone Number
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', Auth::user()->phone) }}"
                               placeholder="+84 xxx xxx xxx"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Date of Birth
                        </label>
                        <input type="date" 
                               id="date_of_birth" 
                               name="date_of_birth" 
                               value="{{ old('date_of_birth', Auth::user()->date_of_birth ? Auth::user()->date_of_birth->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Gender
                        </label>
                        <select id="gender" 
                                name="gender"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Select gender</option>
                            <option value="Male" {{ old('gender', Auth::user()->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', Auth::user()->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', Auth::user()->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Bio -->
                <div class="mt-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Bio
                    </label>
                    <textarea id="bio" 
                              name="bio" 
                              rows="4"
                              maxlength="500"
                              placeholder="Tell us about yourself..."
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none">{{ old('bio', Auth::user()->bio) }}</textarea>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            <span id="bio-count">{{ strlen(Auth::user()->bio ?? '') }}</span>/500 characters
                        </span>
                        @error('bio')
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Location</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            City
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               value="{{ old('city', Auth::user()->city) }}"
                               placeholder="e.g., Hanoi"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Country
                        </label>
                        <input type="text" 
                               id="country" 
                               name="country" 
                               value="{{ old('country', Auth::user()->country) }}"
                               placeholder="e.g., Vietnam"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        @error('country')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Social Media</h2>
                
                <div class="space-y-4">
                    <!-- Facebook -->
                    <div>
                        <label for="facebook" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook
                        </label>
                        <input type="url" 
                               id="facebook" 
                               name="facebook_url" 
                               value="{{ old('facebook_url', Auth::user()->facebook_url) }}"
                               placeholder="https://facebook.com/yourprofile"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <!-- Instagram -->
                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram
                        </label>
                        <input type="url" 
                               id="instagram" 
                               name="instagram_url" 
                               value="{{ old('instagram_url', Auth::user()->instagram_url) }}"
                               placeholder="https://instagram.com/yourprofile"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <!-- LinkedIn -->
                    <div>
                        <label for="linkedin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fab fa-linkedin text-blue-700 mr-2"></i>LinkedIn
                        </label>
                        <input type="url" 
                               id="linkedin" 
                               name="linkedin_url" 
                               value="{{ old('linkedin_url', Auth::user()->linkedin_url) }}"
                               placeholder="https://linkedin.com/in/yourprofile"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between">
                <a href="{{ route('profile') }}" 
                   class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition font-medium">
                    Cancel
                </a>
                
                <button type="submit" 
                        class="px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium shadow-sm">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
// Avatar preview
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Bio character counter
const bioTextarea = document.getElementById('bio');
const bioCount = document.getElementById('bio-count');

if (bioTextarea && bioCount) {
    bioTextarea.addEventListener('input', function() {
        bioCount.textContent = this.value.length;
    });
}
</script>
@endpush
@endsection