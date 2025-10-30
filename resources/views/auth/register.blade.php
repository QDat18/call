<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Choose Account Type - VolunteerConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    
    @include('components.navbar')

    <div class="flex-1 container mx-auto px-4 py-12 flex items-center justify-center">
        <div class="max-w-5xl w-full">
            
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-gray-800 mb-4">Join VolunteerConnect</h1>
                <p class="text-xl text-gray-600">Choose how you want to make a difference</p>
            </div>

            <!-- Account Type Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                
                <!-- Volunteer Card -->
                <a href="{{ route('register.volunteer') }}" 
                   class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-blue-500">
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-8 text-white text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-user text-5xl text-blue-600"></i>
                        </div>
                        <h2 class="text-3xl font-bold mb-2">I'm a Volunteer</h2>
                        <p class="text-blue-100">I want to contribute and help</p>
                    </div>

                    <!-- Content -->
                    <div class="p-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Perfect for you if:</h3>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                <span class="text-gray-700">You want to volunteer your time and skills</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                <span class="text-gray-700">You're looking for meaningful opportunities</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                <span class="text-gray-700">You want to track your volunteer hours</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-blue-600 mt-1"></i>
                                <span class="text-gray-700">You want to make a positive impact</span>
                            </li>
                        </ul>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <span class="text-sm text-gray-500">Free forever</span>
                            <span class="text-blue-600 font-semibold group-hover:translate-x-2 transition-transform">
                                Get Started <i class="fas fa-arrow-right ml-2"></i>
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Organization Card -->
                <a href="{{ route('register.organization') }}" 
                   class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-green-500">
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-8 text-white text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-building text-5xl text-green-600"></i>
                        </div>
                        <h2 class="text-3xl font-bold mb-2">I'm an Organization</h2>
                        <p class="text-green-100">I need volunteers for my cause</p>
                    </div>

                    <!-- Content -->
                    <div class="p-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Perfect for you if:</h3>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-green-600 mt-1"></i>
                                <span class="text-gray-700">You run an NGO, NPO, or charity</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-green-600 mt-1"></i>
                                <span class="text-gray-700">You need volunteers for your projects</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-green-600 mt-1"></i>
                                <span class="text-gray-700">You want to manage volunteer applications</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <i class="fas fa-check-circle text-green-600 mt-1"></i>
                                <span class="text-gray-700">You want to build your volunteer community</span>
                            </li>
                        </ul>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <span class="text-sm text-gray-500">Free to start</span>
                            <span class="text-green-600 font-semibold group-hover:translate-x-2 transition-transform">
                                Get Started <i class="fas fa-arrow-right ml-2"></i>
                            </span>
                        </div>
                    </div>
                </a>

            </div>

            <!-- Stats Section -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="text-4xl font-bold text-indigo-600 mb-2">5,000+</div>
                        <div class="text-gray-600">Active Volunteers</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-green-600 mb-2">500+</div>
                        <div class="text-gray-600">Organizations</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-purple-600 mb-2">10,000+</div>
                        <div class="text-gray-600">Opportunities</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-orange-600 mb-2">50,000+</div>
                        <div class="text-gray-600">Volunteer Hours</div>
                    </div>
                </div>
            </div>

            <!-- Already have account -->
            <div class="text-center">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">
                        Login here
                    </a>
                </p>
            </div>

            <!-- Testimonials -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                    <div class="flex items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Nguyen+Van+A&background=3B82F6&color=fff" 
                             alt="Avatar" class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <div class="font-semibold text-gray-800">Nguyen Van A</div>
                            <div class="text-sm text-gray-600">Volunteer</div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic">
                        "This platform helped me find meaningful volunteer opportunities that match my skills. I've contributed over 100 hours!"
                    </p>
                </div>

                <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Green+Earth+NGO&background=10B981&color=fff" 
                             alt="Avatar" class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <div class="font-semibold text-gray-800">Green Earth NGO</div>
                            <div class="text-sm text-gray-600">Organization</div>
                        </div>
                    </div>
                    <p class="text-gray-700 italic">
                        "We've connected with amazing volunteers through this platform. It's made our recruitment process so much easier!"
                    </p>
                </div>
            </div>

        </div>
    </div>

    @include('components.footer')

</body>
</html>