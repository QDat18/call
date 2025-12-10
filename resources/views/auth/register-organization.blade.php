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
            border-color: #10b981 !important; /* green-500 for organization theme */
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
            outline: none !important;
        }

        .ts-wrapper.multi .ts-control > div {
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

        /* Dropdown options */
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
            background-color: #d1fae5 !important; /* green-100 */
            color: #047857 !important; /* green-700 */
        }

        .ts-dropdown .option.selected {
            background-color: #a7f3d0 !important; /* green-200 */
            color: #065f46 !important; /* green-800 */
            font-weight: 500 !important;
        }

        /* Search highlighting */
        .ts-dropdown .option .highlight {
            background-color: #fef3c7 !important;
            font-weight: 600 !important;
            color: #92400e !important;
        }

        /* Scrollbar styling */
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

        /* Disabled state */
        .ts-control.disabled,
        .ts-control[disabled] {
            background-color: #f9fafb !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
        }

        /* Loading state */
        .ts-wrapper.loading .ts-control::after {
            content: "";
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid #e5e7eb;
            border-top-color: #10b981;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: translateY(-50%) rotate(360deg); }
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

                <form method="POST" action="{{ route('register.organization.submit') }}" id="organizationForm"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Registration errors occurred:</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
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

                        <!-- Logo & Documents Upload -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Organization Logo
                                </label>
                                <input type="file" name="logo" accept="image/*"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                @error('logo')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Verification Document <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="registration_document" accept=".pdf,.jpg,.jpeg,.png" required
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                @error('registration_document')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

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
                            <textarea name="description" rows="4" required maxlength="500"
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

                    <!-- Location with TomSelect -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>Organization Location
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Province / City <span class="text-red-500">*</span>
                                </label>
                                <select id="city-select" class="tom-select" placeholder="Select a province...">
                                    <option value="">Select Province</option>
                                </select>
                                <!-- Hidden inputs for both city and city_name -->
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
                                    District / Ward <span class="text-red-500">*</span>
                                </label>
                                <select id="ward-select" class="tom-select" placeholder="Select a ward..." disabled>
                                    <option value="">Select Province first</option>
                                </select>
                                <!-- Hidden inputs for both district and ward_name -->
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Full Address <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" rows="2" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
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
                                    <input type="password" name="password" id="password" required minlength="8"
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
                                I agree to the <a href="{{ route('terms') }}" target="_blank"
                                    class="text-green-600 hover:underline font-semibold">Terms of Service</a>
                                and <a href="{{ route('privacy') }}" target="_blank"
                                    class="text-green-600 hover:underline font-semibold">Privacy Policy</a>
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
        // ===============================================
        // API ADDRESS - USING DATA FROM LARAVEL DATABASE
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

            // Load provinces on page load
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

                    // Handle old data (if validation fails)
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

        // Load Wards by Province Code
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

        // ===============================================
        // CHARACTER COUNTER
        // ===============================================
        const descTextarea = document.querySelector('textarea[name="description"]');
        const descCount = document.getElementById('desc-count');

        if (descTextarea && descCount) {
            // Initial count
            descCount.textContent = descTextarea.value.length;
            
            descTextarea.addEventListener('input', function () {
                descCount.textContent = this.value.length;
                
                // Visual feedback when approaching limit
                if (this.value.length > 450) {
                    descCount.classList.add('text-orange-600', 'font-semibold');
                } else if (this.value.length >= 500) {
                    descCount.classList.add('text-red-600', 'font-bold');
                } else {
                    descCount.classList.remove('text-orange-600', 'font-semibold', 'text-red-600', 'font-bold');
                }
            });
        }

        // ===============================================
        // PASSWORD VISIBILITY TOGGLE
        // ===============================================
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

        // ===============================================
        // PASSWORD STRENGTH CHECKER
        // ===============================================
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('password-strength');
        const strengthText = document.getElementById('password-text');

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                const password = this.value;
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

        // ===============================================
        // PASSWORD MATCH CHECKER
        // ===============================================
        const confirmPassword = document.getElementById('password_confirmation');
        const matchText = document.getElementById('password-match');

        if (confirmPassword) {
            confirmPassword.addEventListener('input', function () {
                if (this.value === '') {
                    matchText.textContent = '';
                    return;
                }

                if (this.value === passwordInput.value) {
                    matchText.textContent = '✓ Passwords match';
                    matchText.className = 'text-xs mt-1 text-green-600';
                } else {
                    matchText.textContent = '✗ Passwords do not match';
                    matchText.className = 'text-xs mt-1 text-red-600';
                }
            });
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                if (confirmPassword.value !== '') {
                    if (confirmPassword.value === this.value) {
                        matchText.textContent = '✓ Passwords match';
                        matchText.className = 'text-xs mt-1 text-green-600';
                    } else {
                        matchText.textContent = '✗ Passwords do not match';
                        matchText.className = 'text-xs mt-1 text-red-600';
                    }
                }
            });
        }

        // ===============================================
        // FORM VALIDATION
        // ===============================================
        document.getElementById('organizationForm').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirmPass = document.getElementById('password_confirmation').value;

            if (password !== confirmPass) {
                e.preventDefault();
                alert('Passwords do not match!');
                confirmPassword.focus();
                return false;
            }

            // Check if terms are accepted
            const terms = document.getElementById('terms').checked;
            const verifyInfo = document.getElementById('verify_info').checked;

            if (!terms || !verifyInfo) {
                e.preventDefault();
                alert('Please accept all required terms and conditions.');
                return false;
            }
        });
    </script>
</body>

</html>