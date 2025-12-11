@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="space-y-6">
    
    <nav class="flex text-sm font-medium text-gray-500">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.users.index') }}" class="hover:text-indigo-600">Users</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</span>
    </nav>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden relative">
        <div class="h-44 bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600"></div>
        
        <div class="px-8 pb-8 flex flex-col md:flex-row items-end md:items-center gap-6 -mt-16 relative z-10">
            <div class="relative group">
                <img src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) . '&background=fff&color=4f46e5' }}" 
                     class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover bg-white">
                @if($user->is_active)
                    <span class="absolute bottom-2 right-2 w-5 h-5 bg-green-500 border-2 border-white rounded-full" title="Active"></span>
                @else
                    <span class="absolute bottom-2 right-2 w-5 h-5 bg-red-500 border-2 border-white rounded-full" title="Inactive"></span>
                @endif
            </div>
            
            <div class="flex-1 pb-1 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</h1>
                <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-2">
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-600 border border-gray-200">
                        <i class="fas fa-envelope mr-1"></i> {{ $user->email }}
                    </span>
                    
                    @php
                        $roleColors = [
                            'Volunteer' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'Organization' => 'bg-purple-100 text-purple-700 border-purple-200',
                            'Admin' => 'bg-red-100 text-red-700 border-red-200'
                        ];
                        $roleClass = $roleColors[$user->user_type] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $roleClass }}">
                        {{ $user->user_type }}
                    </span>

                    @if($user->is_verified)
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-200">
                            <i class="fas fa-check-circle mr-1"></i> Verified
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex gap-3 mt-4 md:mt-0">
                <a href="{{ route('admin.users.edit', $user->user_id) }}" 
                   class="px-4 py-2 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 shadow-sm transition">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                
                @if($user->is_active)
                <button onclick="toggleStatus({{ $user->user_id }}, 'deactivate')" 
                        class="px-4 py-2 bg-orange-50 border border-orange-200 text-orange-700 font-bold rounded-xl hover:bg-orange-100 shadow-sm transition">
                    <i class="fas fa-ban mr-2"></i> Suspend
                </button>
                @else
                <button onclick="toggleStatus({{ $user->user_id }}, 'activate')" 
                        class="px-4 py-2 bg-green-50 border border-green-200 text-green-700 font-bold rounded-xl hover:bg-green-100 shadow-sm transition">
                    <i class="fas fa-check mr-2"></i> Activate
                </button>
                @endif

                <button onclick="deleteUser({{ $user->user_id }})" 
                        class="px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-lg shadow-red-200 transition">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-indigo-500 rounded-full"></span>
                    Personal Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Phone</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $user->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">Date of Birth</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">City</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $user->city ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase">District</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $user->district ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs font-bold text-gray-400 uppercase">Address</label>
                        <p class="font-medium text-gray-900 mt-1">{{ $user->address ?? 'No address provided.' }}</p>
                    </div>
                </div>
            </div>

            @if($user->user_type == 'Volunteer' && $user->volunteerProfile)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-blue-500 rounded-full"></span>
                    Volunteer Profile
                </h3>
                <div class="space-y-4">
                    @if($user->volunteerProfile->bio)
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Bio</label>
                        <p class="text-gray-700 italic">"{{ $user->volunteerProfile->bio }}"</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Occupation</label>
                            <p class="font-medium text-gray-900">{{ $user->volunteerProfile->occupation ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase">Education</label>
                            <p class="font-medium text-gray-900">{{ $user->volunteerProfile->education_level ?? 'N/A' }}</p>
                        </div>
                    </div>

                    @if($user->volunteerProfile->skills)
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase block mb-2">Skills</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $user->volunteerProfile->skills) as $skill)
                                <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg border border-blue-100">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($user->user_type == 'Organization' && $user->organization)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="w-1 h-6 bg-purple-500 rounded-full"></span>
                    Organization Details
                </h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl border border-purple-100">
                         <div>
                            <p class="text-sm font-bold text-purple-900">{{ $user->organization->organization_name }}</p>
                            <p class="text-xs text-purple-600">{{ $user->organization->organization_type }}</p>
                         </div>
                         <span class="px-3 py-1 bg-white text-purple-700 text-xs font-bold rounded-full border border-purple-200 shadow-sm">
                            {{ $user->organization->verification_status }}
                         </span>
                    </div>
                    
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Description</label>
                        <p class="text-gray-700">{{ $user->organization->description ?? 'No description.' }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="text-center p-3 border border-gray-100 rounded-xl">
                            <div class="text-2xl font-bold text-gray-900">{{ $user->organization->total_opportunities }}</div>
                            <div class="text-xs text-gray-500 font-bold uppercase">Opportunities</div>
                        </div>
                        <div class="text-center p-3 border border-gray-100 rounded-xl">
                            <div class="text-2xl font-bold text-gray-900">{{ $user->organization->rating ?? '0.0' }}</div>
                            <div class="text-xs text-gray-500 font-bold uppercase">Rating</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>

        <div class="space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Activity Overview</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Member Since</span>
                        <span class="text-sm font-bold text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Last Login</span>
                        <span class="text-sm font-bold text-gray-900">
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                        </span>
                    </div>
                    
                    <hr class="border-gray-100">

                    @if($user->user_type == 'Volunteer' && $user->volunteerProfile)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-xs font-bold text-gray-500 uppercase">Hours Volunteered</span>
                                <span class="text-xs font-bold text-indigo-600">{{ $user->volunteerProfile->total_volunteer_hours }}h</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ min(($user->volunteerProfile->total_volunteer_hours / 100) * 100, 100) }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-red-50 rounded-2xl shadow-sm border border-red-100 p-6">
                <h3 class="text-lg font-bold text-red-800 mb-4">Danger Zone</h3>
                <p class="text-xs text-red-600 mb-4">Irreversible actions for this account.</p>
                
                <button onclick="resetPassword({{ $user->user_id }})" 
                        class="w-full mb-3 py-2 bg-white border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-50 transition text-sm">
                    <i class="fas fa-key mr-2"></i> Reset Password
                </button>
                
                <button onclick="deleteUser({{ $user->user_id }})" 
                        class="w-full py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-md transition text-sm">
                    <i class="fas fa-trash-alt mr-2"></i> Delete Account
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function toggleStatus(userId, action) {
        const actionText = action === 'activate' ? 'activate' : 'suspend';
        const color = action === 'activate' ? '#10b981' : '#f59e0b';
        
        Swal.fire({
            title: `Are you sure?`,
            text: `Do you want to ${actionText} this user?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: color,
            confirmButtonText: `Yes, ${actionText}!`
        }).then((result) => {
            if (result.isConfirmed) {
                // Endpoint mapping: activate -> activateUser, deactivate -> deactivateUser/suspendUser
                // Dựa trên Controller bạn cung cấp: có activateUser và suspendUser
                const endpoint = action === 'activate' ? 'activate' : 'deactivate'; // Hoặc 'suspend' tùy route

                fetch(`/admin/users/${userId}/${endpoint}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire('Success', data.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(err => Swal.fire('Error', 'Something went wrong', 'error'));
            }
        });
    }

    function deleteUser(userId) {
        Swal.fire({
            title: 'Delete User?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire('Deleted!', 'User has been deleted.', 'success')
                        .then(() => window.location.href = "{{ route('admin.users.index') }}");
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(err => Swal.fire('Error', 'Connection failed', 'error'));
            }
        });
    }

    function resetPassword(userId) {
        Swal.fire({
            title: 'Reset Password',
            text: 'Send a password reset email to this user?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, send email'
        }).then((result) => {
            if(result.isConfirmed) {
                // Giả định bạn có route gửi mail reset password
                // Nếu chưa có, alert thông báo tính năng đang phát triển
                Swal.fire('Info', 'Password reset email feature is coming soon.', 'info');
            }
        });
    }
</script>
@endpush

@endsection