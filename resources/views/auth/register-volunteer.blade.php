<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Volunteer Registration - VolunteerConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    
    @include('components.navbar')

    <div class="flex-1 container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mb-4">
                    <i class="fas fa-user-plus text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Join as a Volunteer</h1>
                <p class="text-gray-600">Start making a difference in your community today</p>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">Registering as an organization? </span>
                    <a href="{{ route('register.organization') }}" class="text-indigo-600 hover:underline font-semibold">
                        Click here
                    </a>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                
                <form method="POST" action="{{ route('register.volunteer.submit') }}" id="volunteerForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_type" value="Volunteer">

                    <!-- Progress Indicator -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-indigo-600">Step 1 of 2</span>
                            <span class="text-sm text-gray-500">Personal Information</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: 50%"></div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-user mr-2 text-indigo-600"></i>Personal Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="John">
                                @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Doe">
                                @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Date of Birth <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                       max="{{ date('Y-m-d', strtotime('-16 years')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Must be at least 16 years old</p>
                                @error('date_of_birth')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Gender <span class="text-red-500">*</span>
                                </label>
                                <select name="gender" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Select gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-address-book mr-2 text-indigo-600"></i>Contact Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="john@example.com">
                                @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required
                                       pattern="[0-9]{10,11}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="0912345678">
                                @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i>Location
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    City <span class="text-red-500">*</span>
                                </label>
                                <select name="city" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Select city</option>
                                    <option value="Hanoi" {{ old('city') == 'Hanoi' ? 'selected' : '' }}>Hanoi</option>
                                    <option value="Ho Chi Minh" {{ old('city') == 'Ho Chi Minh' ? 'selected' : '' }}>Ho Chi Minh City</option>
                                    <option value="Da Nang" {{ old('city') == 'Da Nang' ? 'selected' : '' }}>Da Nang</option>
                                    <option value="Hai Phong" {{ old('city') == 'Hai Phong' ? 'selected' : '' }}>Hai Phong</option>
                                    <option value="Can Tho" {{ old('city') == 'Can Tho' ? 'selected' : '' }}>Can Tho</option>
                                </select>
                                @error('city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    District
                                </label>
                                <input type="text" name="district" value="{{ old('district') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="District name">
                                @error('district')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Full Address
                            </label>
                            <textarea name="address" rows="2"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Street address">{{ old('address') }}</textarea>
                            @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-lock mr-2 text-indigo-600"></i>Security
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required
                                           minlength="8"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                           placeholder="Minimum 8 characters">
                                    <button type="button" onclick="togglePassword('password')" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600">
                                        <i class="fas fa-eye" id="password-icon"></i>
                                    </button>
                                </div>
                                <div class="mt-2 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="password-strength" class="h-full transition-all duration-300"></div>
                                </div>
                                <p id="password-text" class="text-xs mt-1"></p>
                                @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                           placeholder="Re-enter password">
                                    <button type="button" onclick="togglePassword('password_confirmation')" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600">
                                        <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                                <p id="password-match" class="text-xs mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="terms" id="terms" required
                                   class="mt-1 h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="terms" class="text-sm text-gray-700">
                                I agree to the <a href="{{ route('terms') }}" target="_blank" class="text-indigo-600 hover:underline font-semibold">Terms of Service</a> 
                                and <a href="{{ route('privacy') }}" target="_blank" class="text-indigo-600 hover:underline font-semibold">Privacy Policy</a>
                                <span class="text-red-500">*</span>
                            </label>
                        </div>
                        @error('terms')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 transition">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Login
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition shadow-lg">
                            <i class="fas fa-user-plus mr-2"></i>Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.footer')

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('password-strength');
        const strengthText = document.getElementById('password-text');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            strengthBar.className = 'h-full transition-all duration-300';
            
            if (strength === 0) {
                strengthBar.style.width = '0%';
                strengthText.textContent = '';
            } else if (strength <= 1) {
                strengthBar.style.width = '25%';
                strengthBar.classList.add('bg-red-500');
                strengthText.textContent = 'Weak password';
                strengthText.className = 'text-xs mt-1 text-red-500';
            } else if (strength === 2) {
                strengthBar.style.width = '50%';
                strengthBar.classList.add('bg-orange-500');
                strengthText.textContent = 'Fair password';
                strengthText.className = 'text-xs mt-1 text-orange-500';
            } else if (strength === 3) {
                strengthBar.style.width = '75%';
                strengthBar.classList.add('bg-yellow-500');
                strengthText.textContent = 'Good password';
                strengthText.className = 'text-xs mt-1 text-yellow-600';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.classList.add('bg-green-500');
                strengthText.textContent = 'Strong password';
                strengthText.className = 'text-xs mt-1 text-green-500';
            }
        });

        // Password match checker
        const confirmPassword = document.getElementById('password_confirmation');
        const matchText = document.getElementById('password-match');

        confirmPassword.addEventListener('input', function() {
            if (this.value === '') {
                matchText.textContent = '';
                return;
            }
            
            if (this.value === passwordInput.value) {
                matchText.textContent = 'Passwords match ✓';
                matchText.className = 'text-xs mt-1 text-green-500';
            } else {
                matchText.textContent = 'Passwords do not match';
                matchText.className = 'text-xs mt-1 text-red-500';
            }
        });

        passwordInput.addEventListener('input', function() {
            if (confirmPassword.value !== '') {
                if (confirmPassword.value === this.value) {
                    matchText.textContent = 'Passwords match ✓';
                    matchText.className = 'text-xs mt-1 text-green-500';
                } else {
                    matchText.textContent = 'Passwords do not match';
                    matchText.className = 'text-xs mt-1 text-red-500';
                }
            }
        });
    </script>
</body>
</html>