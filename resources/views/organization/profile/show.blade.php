@extends('layouts.organization')

@section('title', 'Organization Profile')
@section('breadcrumb', 'Organization Profile')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="h-48 bg-gradient-to-r from-green-600 to-emerald-600 relative">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            </div>

            <div class="relative px-8 pb-8">
                <div class="absolute -top-16 left-8">
                    <div class="w-32 h-32 rounded-xl bg-white dark:bg-gray-700 border-4 border-white dark:border-gray-800 shadow-xl flex items-center justify-center overflow-hidden">
                        @if($organization->user->avatar_url)
                            <img src="{{ asset('storage/' . $organization->user->avatar_url) }}"
                                 alt="Logo" class="w-full h-full object-cover"> 
                        @else
                            <i class="fas fa-building text-5xl text-green-600"></i>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <a href="{{ route('organization.profile.edit') }}"
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center space-x-2">
                        <i class="fas fa-edit"></i>
                        <span>Edit Profile</span>
                    </a>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="flex items-center space-x-3">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                            {{ $organization->organization_name }}
                        </h1>

                        @if($organization->verification_status === 'Verified')
                            <div class="flex items-center space-x-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 px-3 py-1 rounded-full">
                                <i class="fas fa-check-circle"></i>
                                <span class="text-sm font-semibold">Verified</span>
                            </div>
                        @elseif($organization->verification_status === 'Pending')
                            <div class="flex items-center space-x-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 px-3 py-1 rounded-full">
                                <i class="fas fa-clock"></i>
                                <span class="text-sm font-semibold">Pending</span>
                            </div>
                        @else
                            <a href="{{ route('organization.verification.request') }}"
                                class="flex items-center space-x-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-3 py-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                <i class="fas fa-shield-alt"></i>
                                <span class="text-sm font-semibold">Get Verified</span>
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4 text-gray-600 dark:text-gray-400">
                        <span class="flex items-center space-x-2">
                            <i class="fas fa-tag"></i>
                            <span>{{ $organization->organization_type }}</span>
                        </span>
                        @if($organization->founded_year)
                            <span class="flex items-center space-x-2">
                                <i class="fas fa-calendar"></i>
                                <span>Founded {{ $organization->founded_year }}</span>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $organization->total_opportunities }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Opportunities</div>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $organization->volunteer_count }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Volunteers</div>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ number_format($organization->rating, 1) }} ⭐
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Rating</div>
                    </div>
                    <div class="bg-orange-50 dark:bg-orange-900/20 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                            {{ $organization->created_at->diffForHumans(null, true) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Member Since</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-info-circle text-green-600 mr-3"></i>
                        About Us
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                        {{ $organization->description ?: 'No description provided yet.' }}
                    </p>
                </div>

                @if($organization->mission_statement)
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl shadow p-6 border-l-4 border-green-600">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-bullseye text-green-600 mr-3"></i>
                            Our Mission
                        </h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed italic">
                            "{{ $organization->mission_statement }}"
                        </p>
                    </div>
                @endif

                @if(!empty($organization->certificates))
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-certificate text-green-600 mr-3"></i>
                            Operating Certificates & Documents
                        </h2>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($organization->certificates as $cert)
                                <div class="group relative cursor-pointer"
                                    onclick="window.open('{{ asset('storage/' . $cert) }}', '_blank')">
                                    <div class="w-full h-48 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900">
                                        <img src="{{ asset('storage/' . $cert) }}" alt="Certificate"
                                            class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300">
                                        
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition duration-300 flex items-center justify-center">
                                            <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition duration-300 text-2xl"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <div class="space-y-6">

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-address-card text-green-600 mr-2"></i>
                        Contact Info
                    </h3>
                    <div class="space-y-3">
                        @if($organization->user->email)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-envelope text-gray-400 mt-1"></i>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $organization->user->email }}</p>
                                </div>
                            </div>
                        @endif

                        @if($organization->user->phone)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-phone text-gray-400 mt-1"></i>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Phone</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $organization->user->phone }}</p>
                                </div>
                            </div>
                        @endif

                        @if($organization->contact_person)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-user text-gray-400 mt-1"></i>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Contact Person</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $organization->contact_person }}</p>
                                </div>
                            </div>
                        @endif

                        @if($organization->website)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-globe text-gray-400 mt-1"></i>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Website</p>
                                    <a href="{{ $organization->website }}" target="_blank"
                                        class="text-sm text-green-600 dark:text-green-400 hover:underline">
                                        {{ $organization->website }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($organization->user->city)
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-map-marker-alt text-gray-400 mt-1"></i>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Location</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $organization->user->city }}
                                        @if($organization->user->district), {{ $organization->user->district }}@endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($organization->registration_number)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-file-contract text-green-600 mr-2"></i>
                            Legal Info
                        </h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Registration Number</p>
                                <p class="text-sm font-mono text-gray-700 dark:text-gray-300">
                                    {{ $organization->registration_number }}
                                </p>
                            </div>
                            <div class="mt-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                                @php
                                    $statusClass = match ($organization->verification_status) {
                                        'Verified' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                                        'Pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                                        default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
                                    };
                                @endphp
                                <span class="inline-block mt-1 px-3 py-1 text-xs rounded-full {{ $statusClass }}">
                                    {{ $organization->verification_status }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                @if($organization->verification_status !== 'Verified')
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl shadow p-6 border border-blue-200 dark:border-blue-800">
                        <div class="text-center">
                            <i class="fas fa-shield-alt text-4xl text-blue-600 dark:text-blue-400 mb-3"></i>
                            <h3 class="font-bold text-gray-800 dark:text-white mb-2">Get Verified Badge</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                Build trust with volunteers by verifying your organization
                            </p>
                            <a href="{{ route('organization.verification.request') }}"
                                class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                                <i class="fas fa-check-circle"></i>
                                <span>Request Verification</span>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection