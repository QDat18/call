<nav class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-50" 
     x-data="{ mobileMenu: false }" 
     aria-label="Main navigation">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hands-helping text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    VolunteerConnect
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('opportunities.index') }}" 
                   class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition {{ request()->routeIs('opportunities.*') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : '' }}">
                    <i class="fas fa-search mr-2"></i>Find Opportunities
                </a>
                <a href="{{ route('organizations.index') }}" 
                   class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition {{ request()->routeIs('organizations.*') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : '' }}">
                    <i class="fas fa-building mr-2"></i>Organizations
                </a>
                <a href="{{ route('about') }}" 
                   class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition {{ request()->routeIs('about') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : '' }}">
                    About Us
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" 
                       class="px-4 py-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-md">
                        Sign Up
                    </a>
                @else
                    <!-- Enhanced authenticated user section -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <a href="{{ route('notifications') }}" class="relative p-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                3
                            </span>
                        </a>
                        
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                           class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Dashboard
                        </a>
                    </div>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenu = !mobileMenu" 
                    class="md:hidden text-gray-700 dark:text-gray-300 transition-transform"
                    :class="{ 'transform rotate-90': mobileMenu }"
                    :aria-expanded="mobileMenu"
                    aria-controls="mobile-menu"
                    aria-label="Toggle mobile menu">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" 
         x-transition
         id="mobile-menu"
         class="md:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700">
        <div class="container mx-auto px-4 py-4 space-y-3">
            <a href="{{ route('opportunities.index') }}" 
               class="block py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('opportunities.*') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : '' }}">
                <i class="fas fa-search mr-2"></i>Find Opportunities
            </a>
            <a href="{{ route('organizations.index') }}" 
               class="block py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('organizations.*') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : '' }}">
                <i class="fas fa-building mr-2"></i>Organizations
            </a>
            <a href="{{ route('about') }}" 
               class="block py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('about') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : '' }}">
                About Us
            </a>
            @guest
                <a href="{{ route('login') }}" class="block py-2 text-indigo-600 dark:text-indigo-400 font-semibold">
                    Login
                </a>
                <a href="{{ route('register') }}" 
                   class="block py-2 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg text-center">
                    Sign Up
                </a>
            @else
                <a href="{{ route('notifications') }}" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                    <i class="fas fa-bell mr-2"></i>Notifications
                    <span class="ml-2 w-5 h-5 bg-red-500 text-white text-xs rounded-full inline-flex items-center justify-center">3</span>
                </a>
                <a href="{{ route('dashboard') }}" class="block py-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="border-t dark:border-gray-700 pt-3 mt-3">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</nav>