@php
    $isActive = request()->routeIs($route . '*');
@endphp

<a href="{{ route($route) }}"
   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition
          {{ $isActive ? 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
    <i class="fas {{ $icon }} w-5"></i>
    {{ $slot }}
</a>