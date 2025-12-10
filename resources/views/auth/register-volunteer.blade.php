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
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <style>
        /* ================================================
           TOM SELECT CUSTOM STYLES - IMPROVED LAYOUT
           ================================================ */

        /* Main control input styling */
        .ts-control {
            padding: 0.75rem 1rem !important;
            border-radius: 0.5rem !important;
            border: 1px solid #d1d5db !important;
            background-color: white !important;
            min-height: 48px !important;
        }

        .ts-control:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1) !important;
            outline: none !important;
        }

        .ts-wrapper.multi .ts-control>div {
            display: inline-flex !important;
        }

        /* Dropdown container */
        .ts-dropdown {
            position: absolute !important;
            z-index: 9999 !important;
            margin-top: 4px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            background: white !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            max-height: 300px !important;
            overflow-y: auto !important;
        }

        .ts-dropdown .option {
            padding: 0.75rem 1rem !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            border-bottom: 1px solid #f3f4f6 !important;
        }

        .ts-dropdown .option:last-child {
            border-bottom: none !important;
        }

        .ts-dropdown .option:hover,
        .ts-dropdown .option.active {
            background-color: #eef2ff !important;
            color: #4f46e5 !important;
        }

        .ts-dropdown .option.selected {
            background-color: #e0e7ff !important;
            color: #4338ca !important;
            font-weight: 500 !important;
        }

        .ts-dropdown .option .highlight {
            background-color: #fef3c7 !important;
            font-weight: 600 !important;
            color: #92400e !important;
        }

        .ts-dropdown::-webkit-scrollbar {
            width: 8px;
        }

        .ts-dropdown::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 0 0.5rem 0.5rem 0;
        }

        .ts-dropdown::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .ts-dropdown::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .ts-control.disabled,
        .ts-control[disabled] {
            background-color: #f9fafb !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
        }

        .ts-wrapper.loading .ts-control::after {
            content: "";
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid #e5e7eb;
            border-top-color: #6366f1;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: translateY(-50%) rotate(360deg);
            }
        }

        .ts-control input::placeholder {
            color: #9ca3af !important;
            font-size: 0.875rem !important;
        }

        @media (max-width: 640px) {
            .ts-dropdown {
                max-height: 200px !important;
            }

            .ts-dropdown .option {
                padding: 0.625rem 0.875rem !important;
                font-size: 0.875rem !important;
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    @include('components.navbar')

    <div class="flex-1 container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
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

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form method="POST" action="{{ route('register.volunteer.submit') }}" id="volunteerForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_type" value="Volunteer">

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
                                    Province / City <span class="text-red-500">*</span>
                                </label>
                                <select id="city-select" class="tom-select" placeholder="Select a province...">
                                    <option value="">Select Province</option>
                                </select>
                                <!-- Send both city and city_name to backend -->
                                <input type="hidden" name="city" id="city-input">
                                <input type="hidden" name="city_name" id="city-name-input">
                                @error('city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @error('city_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Ward / Commune <span class="text-red-500">*</span>
                                </label>
                                <select id="ward-select" class="tom-select" placeholder="Select a ward..." disabled>
                                    <option value="">Select Province first</option>
                                </select>
                                <!-- Send both district and ward_name to backend -->
                                <input type="hidden" name="district" id="district-input">
                                <input type="hidden" name="ward_name" id="ward-name-input">
                                @error('district')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @error('ward_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Address</label>
                            <textarea name="address" rows="2"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="House number, street name...">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Security -->
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
                                    <input type="password" name="password" id="password" required minlength="8"
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

                    <!-- Terms -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="terms" id="terms" required
                                class="mt-1 h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="terms" class="text-sm text-gray-700">
                                I agree to the <a href="{{ route('terms') }}" target="_blank"
                                    class="text-indigo-600 hover:underline font-semibold">Terms of Service</a>
                                and <a href="{{ route('privacy') }}" target="_blank"
                                    class="text-indigo-600 hover:underline font-semibold">Privacy Policy</a>
                                <span class="text-red-500">*</span>
                            </label>
                        </div>
                        @error('terms')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
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
        // ===============================================
        // API CONFIGURATION
        // ===============================================
        const API_PROVINCES = '{{ route('api.locations.provinces') }}';
        const API_WARDS_TEMPLATE = '{{ route('api.locations.wards', ['provinceCode' => ':code']) }}';

        let cityTom, wardTom;

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Tom Select for Province
            cityTom = new TomSelect('#city-select', {
                create: false,
                sortField: { field: 'text', direction: 'asc' },
                onChange: function (value) {
                    if (value) {
                        const option = this.options[value];
                        // Set both city and city_name
                        document.getElementById('city-input').value = option.text;
                        document.getElementById('city-name-input').value = option.text;
                        loadWards(value);
                    } else {
                        document.getElementById('city-input').value = '';
                        document.getElementById('city-name-input').value = '';
                        wardTom.clear();
                        wardTom.clearOptions();
                        wardTom.disable();
                    }
                }
            });

            // Initialize Tom Select for Ward
            wardTom = new TomSelect('#ward-select', {
                create: false,
                sortField: { field: 'text', direction: 'asc' },
                onChange: function (value) {
                    if (value) {
                        const option = this.options[value];
                        // Set both district and ward_name
                        document.getElementById('district-input').value = option.text;
                        document.getElementById('ward-name-input').value = option.text;
                    } else {
                        document.getElementById('district-input').value = '';
                        document.getElementById('ward-name-input').value = '';
                    }
                }
            });

            loadProvinces();
        });

        // Load Provinces
        async function loadProvinces() {
            try {
                const res = await fetch(API_PROVINCES);
                const json = await res.json();

                if (json.data) {
                    cityTom.clearOptions();
                    json.data.forEach(province => {
                        cityTom.addOption({
                            value: province.code,
                            text: province.name
                        });
                    });

                    // Handle old data
                    const oldCityName = '{{ old('city_name') }}';
                    const oldCity = '{{ old('city') }}';
                    if (oldCityName || oldCity) {
                        const searchName = oldCityName || oldCity;
                        const oldProvince = json.data.find(p => p.name === searchName);
                        if (oldProvince) {
                            cityTom.setValue(oldProvince.code);
                        }
                    }
                }
            } catch (error) {
                console.error('Error loading provinces:', error);
                alert('Failed to load provinces. Please refresh the page.');
            }
        }

        // Load Wards
        async function loadWards(provinceCode) {
            wardTom.disable();
            wardTom.clear();
            wardTom.clearOptions();
            wardTom.settings.placeholder = "Loading...";
            wardTom.sync();

            if (!provinceCode) return;

            try {
                const url = API_WARDS_TEMPLATE.replace(':code', provinceCode);
                const res = await fetch(url);
                const json = await res.json();

                if (json.data && json.data.length > 0) {
                    json.data.forEach(ward => {
                        wardTom.addOption({
                            value: ward.code,
                            text: ward.name
                        });
                    });

                    wardTom.enable();
                    wardTom.settings.placeholder = "Select Ward";
                    wardTom.sync();

                    // Handle old data
                    const oldWardName = '{{ old('ward_name') }}';
                    const oldDistrict = '{{ old('district') }}';
                    if (oldWardName || oldDistrict) {
                        const searchName = oldWardName || oldDistrict;
                        const oldWard = json.data.find(w => w.name === searchName);
                        if (oldWard) {
                            wardTom.setValue(oldWard.code);
                        }
                    }
                } else {
                    wardTom.settings.placeholder = "No wards found";
                    wardTom.sync();
                }
            } catch (error) {
                console.error('Error loading wards:', error);
                wardTom.settings.placeholder = "Error loading wards";
                wardTom.sync();
            }
        }

        // Password visibility toggle
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
        const passwordConfirmation = document.getElementById('password_confirmation');

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                const password = this.value;
                const strengthBar = document.getElementById('password-strength');
                const strengthText = document.getElementById('password-text');

                let strength = 0;
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]+/)) strength++;
                if (password.match(/[A-Z]+/)) strength++;
                if (password.match(/[0-9]+/)) strength++;
                if (password.match(/[^a-zA-Z0-9]+/)) strength++;

                const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
                const texts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
                const widths = ['20%', '40%', '60%', '80%', '100%'];

                strengthBar.className = `h-full transition-all duration-300 ${colors[strength - 1] || 'bg-gray-300'}`;
                strengthBar.style.width = widths[strength - 1] || '0%';
                strengthText.textContent = texts[strength - 1] || '';
                strengthText.className = `text-xs mt-1 ${colors[strength - 1]?.replace('bg-', 'text-') || 'text-gray-500'}`;
            });
        }

        // Password match checker
        if (passwordConfirmation) {
            passwordConfirmation.addEventListener('input', function () {
                const password = passwordInput.value;
                const confirmation = this.value;
                const matchText = document.getElementById('password-match');

                if (confirmation === '') {
                    matchText.textContent = '';
                } else if (password === confirmation) {
                    matchText.textContent = '✓ Passwords match';
                    matchText.className = 'text-xs mt-1 text-green-600';
                } else {
                    matchText.textContent = '✗ Passwords do not match';
                    matchText.className = 'text-xs mt-1 text-red-600';
                }
            });
        }
    </script>
</body>

</html>