@extends('layouts.organization')

@section('title', 'Edit Profile')
@section('breadcrumb', 'Edit Profile')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
        
        <!-- Header -->
        <div class="border-b dark:border-gray-700 pb-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                <i class="fas fa-edit text-green-600 mr-3"></i>
                Edit Organization Profile
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Update your organization information</p>
        </div>

        <!-- Form -->
        <form id="profileForm" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Avatar/Logo Upload -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">
                    <i class="fas fa-image text-green-600 mr-2"></i>
                    Organization Logo
                </h3>

                <div class="flex flex-col md:flex-row items-center gap-6">
                    <!-- Current Logo Preview -->
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img id="logo-preview" 
                                 src="{{ $organization->user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($organization->organization_name).'&background=059669&color=fff&size=200' }}" 
                                 alt="Logo" 
                                 class="w-32 h-32 rounded-xl object-cover border-4 border-white dark:border-gray-700 shadow-lg">
                            
                            <!-- Remove button if has custom avatar -->
                            @if($organization->user->avatar_url)
                            <button type="button" 
                                    onclick="removeLogo()"
                                    class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg transition">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Upload Section -->
                    <div class="flex-1 w-full">
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-green-500 dark:hover:border-green-500 transition cursor-pointer"
                             onclick="document.getElementById('logo-input').click()">
                            <input type="file" 
                                   id="logo-input" 
                                   name="avatar" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                   class="hidden"
                                   onchange="previewLogo(event)">
                            
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-700 dark:text-gray-300 font-medium mb-1">
                                Click to upload or drag and drop
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                PNG, JPG, GIF up to 2MB
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                                Recommended size: 200x200px
                            </p>
                        </div>

                        <p id="file-name" class="text-sm text-green-600 dark:text-green-400 mt-2 hidden"></p>
                        <p class="text-red-500 text-sm mt-1 hidden" id="error-avatar"></p>
                    </div>
                </div>
            </div>

            <!-- Organization Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Organization Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="organization_name" 
                       value="{{ $organization->organization_name }}" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                       placeholder="Enter organization name">
                <p class="text-red-500 text-sm mt-1 hidden" id="error-organization_name"></p>
            </div>

            <!-- Organization Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Organization Type <span class="text-red-500">*</span>
                </label>
                <select name="organization_type" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Select type</option>
                    <option value="NGO" {{ $organization->organization_type === 'NGO' ? 'selected' : '' }}>NGO</option>
                    <option value="NPO" {{ $organization->organization_type === 'NPO' ? 'selected' : '' }}>NPO</option>
                    <option value="Charity" {{ $organization->organization_type === 'Charity' ? 'selected' : '' }}>Charity</option>
                    <option value="School" {{ $organization->organization_type === 'School' ? 'selected' : '' }}>School</option>
                    <option value="Hospital" {{ $organization->organization_type === 'Hospital' ? 'selected' : '' }}>Hospital</option>
                    <option value="Community Group" {{ $organization->organization_type === 'Community Group' ? 'selected' : '' }}>Community Group</option>
                </select>
                <p class="text-red-500 text-sm mt-1 hidden" id="error-organization_type"></p>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    About Us
                </label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                          placeholder="Tell volunteers about your organization...">{{ $organization->description }}</textarea>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    <span id="desc-count">{{ strlen($organization->description ?? '') }}</span>/1000 characters
                </p>
            </div>

            <!-- Mission Statement -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Mission Statement
                </label>
                <textarea name="mission_statement" rows="3"
                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                          placeholder="Your organization's mission and vision...">{{ $organization->mission_statement }}</textarea>
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Contact Person
                    </label>
                    <input type="text" name="contact_person" 
                           value="{{ $organization->contact_person }}"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Full name">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Website
                    </label>
                    <input type="url" name="website" 
                           value="{{ $organization->website }}"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="https://example.com">
                </div>
            </div>

            <!-- Legal Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Registration Number
                    </label>
                    <input type="text" name="registration_number" 
                           value="{{ $organization->registration_number }}"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="Legal registration number">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Founded Year
                    </label>
                    <input type="number" name="founded_year" 
                           value="{{ $organization->founded_year }}"
                           min="1900" max="{{ date('Y') }}"
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                           placeholder="{{ date('Y') }}">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t dark:border-gray-700">
                <a href="{{ route('organization.profile.show') }}" 
                   class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>

    </div>

</div>

@push('scripts')
<script>
// Logo preview
function previewLogo(event) {
    const file = event.target.files[0];
    const fileName = document.getElementById('file-name');
    const preview = document.getElementById('logo-preview');
    const errorElement = document.getElementById('error-avatar');
    
    // Reset error
    errorElement.textContent = '';
    errorElement.classList.add('hidden');
    
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            errorElement.textContent = 'File size must not exceed 2MB';
            errorElement.classList.remove('hidden');
            event.target.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            errorElement.textContent = 'Only JPG, PNG, and GIF images are allowed';
            errorElement.classList.remove('hidden');
            event.target.value = '';
            return;
        }
        
        // Show file name
        fileName.textContent = '✓ ' + file.name;
        fileName.classList.remove('hidden');
        
        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

// Remove logo
function removeLogo() {
    if (confirm('Are you sure you want to remove the logo?')) {
        document.getElementById('logo-input').value = '';
        document.getElementById('file-name').classList.add('hidden');
        
        // Reset to default avatar
        const orgName = '{{ $organization->organization_name }}';
        document.getElementById('logo-preview').src = 
            'https://ui-avatars.com/api/?name=' + encodeURIComponent(orgName) + '&background=059669&color=fff&size=200';
        
        // TODO: Send request to delete avatar from server
        showToast('Logo removed. Click Save to apply changes.', 'info');
    }
}

// Character counter for description
const descTextarea = document.querySelector('textarea[name="description"]');
const descCount = document.getElementById('desc-count');

descTextarea?.addEventListener('input', function() {
    const count = this.value.length;
    descCount.textContent = count;
    
    if (count > 1000) {
        descCount.classList.add('text-red-500');
        descCount.classList.remove('text-gray-500');
    } else {
        descCount.classList.add('text-gray-500');
        descCount.classList.remove('text-red-500');
    }
});

// Form submission
document.getElementById('profileForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Clear previous errors
    document.querySelectorAll('[id^="error-"]').forEach(el => {
        el.textContent = '';
        el.classList.add('hidden');
    });
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    
    try {
        const response = await fetch('{{ route("organization.profile.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToast('Profile updated successfully!', 'success');
            setTimeout(() => {
                window.location.href = '{{ route("organization.profile.show") }}';
            }, 1500);
        } else {
            // Show validation errors
            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const errorEl = document.getElementById(`error-${key}`);
                    if (errorEl) {
                        errorEl.textContent = data.errors[key][0];
                        errorEl.classList.remove('hidden');
                    }
                });
            }
            showToast(data.message || 'Failed to update profile', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});
</script>
@endpush
@endsection