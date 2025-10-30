<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Organization Registration - VolunteerConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    
    @include('components.navbar')

    <div class="flex-1 container mx-auto px-4 py-12">
        <div class="max-w-5xl mx-auto">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full mb-4">
                    <i class="fas fa-building text-3xl text-white"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Register Your Organization</h1>
                <p class="text-gray-600">Connect with talented volunteers ready to support your cause</p>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">Registering as a volunteer? </span>
                    <a href="{{ route('register.volunteer') }}" class="text-green-600 hover:underline font-semibold">
                        Click here
                    </a>
                </div>
            </div>

            <!-- Benefits Banner -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 mb-8">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                    Why Register Your Organization?
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span class="text-gray-700">Access to skilled volunteers</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span class="text-gray-700">Free opportunity posting</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span class="text-gray-700">Get verified badge</span>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                
                <form method="POST" action="{{ route('register.organization.submit') }}" id="organizationForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_type" value="Organization">

                    <!-- Progress Indicator -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-green-600">Complete Profile</span>
                            <span class="text-sm text-gray-500">All fields required</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 33%"></div>
                        </div>
                    </div>

                    <!-- Organization Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-building mr-2 text-green-600"></i>Organization Information
                        </h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Organization Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="organization_name" value="{{ old('organization_name') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Enter your organization's official name">
                            @error('organization_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Organization Type <span class="text-red-500">*</span>
                                </label>
                                <select name="organization_type" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">Select type</option>
                                    <option value="NGO" {{ old('organization_type') == 'NGO' ? 'selected' : '' }}>NGO</option>
                                    <option value="NPO" {{ old('organization_type') == 'NPO' ? 'selected' : '' }}>NPO (Non-Profit)</option>
                                    <option value="Charity" {{ old('organization_type') == 'Charity' ? 'selected' : '' }}>Charity</option>
                                    <option value="School" {{ old('organization_type') == 'School' ? 'selected' : '' }}>School</option>
                                    <option value="Hospital" {{ old('organization_type') == 'Hospital' ? 'selected' : '' }}>Hospital</option>
                                    <option value="Community Group" {{ old('organization_type') == 'Community Group' ? 'selected' : '' }}>Community Group</option>
                                </select>
                                @error('organization_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Founded Year <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="founded_year" value="{{ old('founded_year') }}" required
                                       min="1900" max="{{ date('Y') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="{{ date('Y') }}">
                                @error('founded_year')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                About Your Organization <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" rows="4" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                      placeholder="Tell volunteers about your organization, mission, and activities...">{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">
                                <span id="desc-count">0</span>/500 characters
                            </p>
                            @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mission Statement
                            </label>
                            <textarea name="mission_statement" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                      placeholder="What is your organization's mission and vision?">{{ old('mission_statement') }}</textarea>
                            @error('mission_statement')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Legal Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-file-contract mr-2 text-green-600"></i>Legal Information
                        </h3>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">Why do we need this?</p>
                                    <p>Registration number helps verify your organization's legitimacy and builds trust with volunteers.</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Registration Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="registration_number" value="{{ old('registration_number') }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Enter legal registration number">
                            <p class="text-xs text-gray-500 mt-1">Business registration, NGO certificate, or Tax ID number</p>
                            @error('registration_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Official Website
                            </label>
                            <input type="url" name="website" value="{{ old('website') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="https://yourorganization.com">
                            @error('website')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Representative Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-user-tie mr-2 text-green-600"></i>Representative Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Representative's first name">
                                @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Representative's last name">
                                @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Person Name
                            </label>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                   placeholder="Primary contact person (if different from representative)">
                            @error('contact_person')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-address-book mr-2 text-green-600"></i>Contact Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Official Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="official@organization.com">
                                <p class="text-xs text-gray-500 mt-1">Use your organization's email domain</p>
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
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
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
                            <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>Organization Location
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    City <span class="text-red-500">*</span>
                                </label>
                                <select name="city" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
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
                                    District <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="district" value="{{ old('district') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="District name">
                                @error('district')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Full Address <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" rows="2" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                      placeholder="Street address, building number...">{{ old('address') }}</textarea>
                            @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-lock mr-2 text-green-600"></i>Account Security
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required
                                           minlength="8"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           placeholder="Minimum 8 characters">
                                    <button type="button" onclick="togglePassword('password')" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600">
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
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           placeholder="Re-enter password">
                                    <button type="button" onclick="togglePassword('password_confirmation')" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600">
                                        <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                    </button>
                                </div>
                                <p id="password-match" class="text-xs mt-1"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="bg-gray-50 rounded-lg p-6 space-y-3">
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="terms" id="terms" required
                                   class="mt-1 h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <label for="terms" class="text-sm text-gray-700">
                                I agree to the <a href="{{ route('terms') }}" target="_blank" class="text-green-600 hover:underline font-semibold">Terms of Service</a> 
                                and <a href="{{ route('privacy') }}" target="_blank" class="text-green-600 hover:underline font-semibold">Privacy Policy</a>
                                <span class="text-red-500">*</span>
                            </label>
                        </div>

                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="verify_info" id="verify_info" required
                                   class="mt-1 h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <label for="verify_info" class="text-sm text-gray-700">
                                I confirm that all information provided is accurate and that I have the authority to represent this organization
                                <span class="text-red-500">*</span>
                            </label>
                        </div>

                        @error('terms')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 transition">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Login
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-semibold hover:from-green-700 hover:to-emerald-700 transition shadow-lg">
                            <i class="fas fa-building mr-2"></i>Register Organization
                        </button>
                    </div>
                </form>
            </div>

            <!-- Next Steps Info -->
            <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6">
                <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    What happens next?
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-700">
                    <div class="flex items-start space-x-2">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                        <span>Your account will be created immediately</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                        <span>Submit documents for verification (recommended)</span>
                    </div>
                    <div class="flex items-start space-x-2">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                        <span>Start posting opportunities and connecting with volunteers</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')

    <script>
        // Character counter for description
        const descTextarea = document.querySelector('textarea[name="description"]');
        const descCount = document.getElementById('desc-count');

        descTextarea?.addEventListener('input', function() {
            descCount.textContent = this.value.length;
        });

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

        // Form validation before submit
        document.getElementById('organizationForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPass = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPass) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
        });
    </script>
</body>
</html>