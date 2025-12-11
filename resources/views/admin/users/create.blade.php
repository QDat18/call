@extends('layouts.admin')

@section('title', 'Create New User')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Create User</h2>
            <nav class="flex text-sm font-medium text-gray-500 mt-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin.users.index') }}" class="hover:text-indigo-600">Users</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">Create</span>
            </nav>
        </div>
        <a href="{{ route('admin.users.index') }}" 
           class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition shadow-sm font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">Profile Picture</h3>
                
                <div class="relative w-40 h-40 mx-auto mb-6 group cursor-pointer" onclick="document.getElementById('avatarInput').click()">
                    <img id="avatarPreview" 
                         src="https://ui-avatars.com/api/?name=New+User&background=f3f4f6&color=6b7280" 
                         class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg group-hover:opacity-75 transition duration-300">
                    
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <i class="fas fa-camera text-gray-800 text-3xl drop-shadow-md"></i>
                    </div>
                </div>
                
                <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                
                <button type="button" onclick="document.getElementById('avatarInput').click()"
                    class="text-sm text-indigo-600 font-bold hover:text-indigo-700 hover:underline">
                    Choose Image
                </button>
                <p class="text-xs text-gray-400 mt-2">JPG, PNG or GIF. Max 2MB.</p>

                @error('avatar')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-user-circle text-indigo-500"></i> Account Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('first_name') border-red-500 @enderror"
                            placeholder="e.g. John">
                        @error('first_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('last_name') border-red-500 @enderror"
                            placeholder="e.g. Doe">
                        @error('last_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('email') border-red-500 @enderror"
                                placeholder="john.doe@example.com">
                        </div>
                        @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="0912345678">
                        @error('phone') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">City <span class="text-red-500">*</span></label>
                        <input type="text" name="city" value="{{ old('city') }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="e.g. Hanoi">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Role / User Type <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm hover:border-indigo-200 peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500">
                                <input type="radio" name="user_type" value="Volunteer" class="peer sr-only" {{ old('user_type') == 'Volunteer' ? 'checked' : '' }} checked>
                                <div class="flex flex-col items-center w-full">
                                    <i class="fas fa-hand-holding-heart text-2xl text-blue-500 mb-2"></i>
                                    <span class="text-sm font-bold text-gray-900">Volunteer</span>
                                </div>
                                <div class="absolute -inset-px rounded-xl border-2 border-transparent peer-checked:border-indigo-500"></div>
                            </label>

                            <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm hover:border-indigo-200">
                                <input type="radio" name="user_type" value="Organization" class="peer sr-only" {{ old('user_type') == 'Organization' ? 'checked' : '' }}>
                                <div class="flex flex-col items-center w-full">
                                    <i class="fas fa-building text-2xl text-purple-500 mb-2"></i>
                                    <span class="text-sm font-bold text-gray-900">Organization</span>
                                </div>
                                <div class="absolute -inset-px rounded-xl border-2 border-transparent peer-checked:border-indigo-500"></div>
                            </label>

                            <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm hover:border-indigo-200">
                                <input type="radio" name="user_type" value="Admin" class="peer sr-only" {{ old('user_type') == 'Admin' ? 'checked' : '' }}>
                                <div class="flex flex-col items-center w-full">
                                    <i class="fas fa-user-shield text-2xl text-red-500 mb-2"></i>
                                    <span class="text-sm font-bold text-gray-900">Admin</span>
                                </div>
                                <div class="absolute -inset-px rounded-xl border-2 border-transparent peer-checked:border-indigo-500"></div>
                            </label>
                        </div>
                        @error('user_type') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-lock text-indigo-500"></i> Security
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition"
                                placeholder="Min 8 characters">
                            @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 transition"
                                placeholder="Re-enter password">
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="reset" class="px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">
                        Reset
                    </button>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition flex items-center">
                        <i class="fas fa-check mr-2"></i> Create Account
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection