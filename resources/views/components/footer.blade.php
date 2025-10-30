<footer class="bg-gray-900 text-white mt-auto">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <!-- About -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-hands-helping text-xl"></i>
                    </div>
                    <span class="text-xl font-bold">VolunteerConnect</span>
                </div>
                <p class="text-gray-400 text-sm mb-4">
                    Connecting volunteers with meaningful opportunities to make a difference in communities across Vietnam.
                </p>
                <div class="flex space-x-3">
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600 transition">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600 transition">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600 transition">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-indigo-600 transition">
                        <i class="fab fa-linkedin-in text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('opportunities.index') }}" class="text-gray-400 hover:text-white transition">Find Opportunities</a></li>
                    <li><a href="{{ route('organizations.index') }}" class="text-gray-400 hover:text-white transition">Organizations</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">How It Works</a></li>
                </ul>
            </div>

            <!-- For Organizations -->
            <div>
                <h3 class="text-lg font-bold mb-4">For Organizations</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('register') }}?type=organization" class="text-gray-400 hover:text-white transition">Create Organization Account</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Post Opportunities</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Manage Volunteers</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Success Stories</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Pricing</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-lg font-bold mb-4">Support</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Help Center</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="text-gray-400 hover:text-white transition">Terms of Service</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Community Guidelines</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row items-center justify-between">
            <p class="text-gray-400 text-sm">
                © {{ date('Y') }} VolunteerConnect. All rights reserved.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0 text-sm">
                <a href="#" class="text-gray-400 hover:text-white transition">Sitemap</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Accessibility</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>