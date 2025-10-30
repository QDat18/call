@extends('layouts.organization')

@section('title', 'Edit Opportunity')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('organization.opportunities.show', $opportunity->opportunity_id) }}" 
           class="inline-flex items-center gap-2 text-green-600 hover:text-green-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Opportunity
        </a>
    </div>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Opportunity</h1>
        <p class="text-gray-600 mt-1">Update the details of your volunteer opportunity</p>
    </div>

    <form id="editOpportunityForm" method="POST" action="{{ route('organization.opportunities.update', $opportunity->opportunity_id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Basic Information</h2>
                    
                    <div class="space-y-4">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   required
                                   maxlength="200"
                                   value="{{ old('title', $opportunity->title) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" 
                                        {{ old('category_id', $opportunity->category_id) == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" 
                                      required
                                      rows="6"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('description', $opportunity->description) }}</textarea>
                        </div>

                        <!-- Requirements -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Requirements
                            </label>
                            <textarea name="requirements" 
                                      rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('requirements', $opportunity->requirements) }}</textarea>
                        </div>

                        <!-- Benefits -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Benefits
                            </label>
                            <textarea name="benefits" 
                                      rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('benefits', $opportunity->benefits) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Schedule & Location -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Schedule & Location</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Start Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Start Date
                            </label>
                            <input type="date" 
                                   name="start_date"
                                   value="{{ old('start_date', $opportunity->start_date) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                End Date
                            </label>
                            <input type="date" 
                                   name="end_date"
                                   value="{{ old('end_date', $opportunity->end_date) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <!-- Time Commitment -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Time Commitment
                            </label>
                            <select name="time_commitment"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="1-2 hours" {{ old('time_commitment', $opportunity->time_commitment) == '1-2 hours' ? 'selected' : '' }}>1-2 hours</option>
                                <option value="3-5 hours" {{ old('time_commitment', $opportunity->time_commitment) == '3-5 hours' ? 'selected' : '' }}>3-5 hours</option>
                                <option value="6-8 hours" {{ old('time_commitment', $opportunity->time_commitment) == '6-8 hours' ? 'selected' : '' }}>6-8 hours</option>
                                <option value="Full day" {{ old('time_commitment', $opportunity->time_commitment) == 'Full day' ? 'selected' : '' }}>Full day</option>
                                <option value="Multiple days" {{ old('time_commitment', $opportunity->time_commitment) == 'Multiple days' ? 'selected' : '' }}>Multiple days</option>
                            </select>
                        </div>

                        <!-- Schedule Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Schedule Type
                            </label>
                            <select name="schedule_type"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="One-time" {{ old('schedule_type', $opportunity->schedule_type) == 'One-time' ? 'selected' : '' }}>One-time</option>
                                <option value="Weekly" {{ old('schedule_type', $opportunity->schedule_type) == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="Monthly" {{ old('schedule_type', $opportunity->schedule_type) == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="Flexible" {{ old('schedule_type', $opportunity->schedule_type) == 'Flexible' ? 'selected' : '' }}>Flexible</option>
                            </select>
                        </div>

                        <!-- Location -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Location <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="location" 
                                   required
                                   maxlength="200"
                                   value="{{ old('location', $opportunity->location) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <!-- Application Deadline -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Application Deadline
                            </label>
                            <input type="date" 
                                   name="application_deadline"
                                   value="{{ old('application_deadline', $opportunity->application_deadline) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Volunteer Requirements -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Volunteer Requirements</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Volunteers Needed -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Volunteers Needed <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="volunteers_needed" 
                                   required
                                   min="1"
                                   value="{{ old('volunteers_needed', $opportunity->volunteers_needed) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Currently {{ $opportunity->volunteers_registered }} registered</p>
                        </div>

                        <!-- Minimum Age -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Minimum Age
                            </label>
                            <input type="number" 
                                   name="min_age" 
                                   min="16"
                                   value="{{ old('min_age', $opportunity->min_age ?? 16) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <!-- Experience Needed -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Experience Level
                            </label>
                            <select name="experience_needed"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="No experience" {{ old('experience_needed', $opportunity->experience_needed) == 'No experience' ? 'selected' : '' }}>No experience required</option>
                                <option value="Some experience" {{ old('experience_needed', $opportunity->experience_needed) == 'Some experience' ? 'selected' : '' }}>Some experience preferred</option>
                                <option value="Experienced" {{ old('experience_needed', $opportunity->experience_needed) == 'Experienced' ? 'selected' : '' }}>Experienced volunteers only</option>
                            </select>
                        </div>

                        <!-- Required Skills -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Required Skills
                            </label>
                            <input type="text" 
                                   name="required_skills"
                                   value="{{ old('required_skills', $opportunity->required_skills) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="e.g., Teaching, Communication, English">
                            <p class="text-sm text-gray-500 mt-1">Separate multiple skills with commas</p>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Status</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Opportunity Status
                        </label>
                        <select name="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="Active" {{ old('status', $opportunity->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Paused" {{ old('status', $opportunity->status) == 'Paused' ? 'selected' : '' }}>Paused</option>
                            <option value="Completed" {{ old('status', $opportunity->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ old('status', $opportunity->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Change the visibility and status of this opportunity</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Current Stats -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($opportunity->status == 'Active') bg-green-100 text-green-800
                                @elseif($opportunity->status == 'Paused') bg-yellow-100 text-yellow-800
                                @elseif($opportunity->status == 'Completed') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $opportunity->status }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Views</span>
                            <span class="font-semibold text-gray-800">{{ $opportunity->view_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Applications</span>
                            <span class="font-semibold text-gray-800">{{ $opportunity->application_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Registered</span>
                            <span class="font-semibold text-green-600">{{ $opportunity->volunteers_registered }}/{{ $opportunity->volunteers_needed }}</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-xs text-gray-500">Created {{ $opportunity->created_at->diffForHumans() }}</p>
                            <p class="text-xs text-gray-500">Updated {{ $opportunity->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Warning Card -->
                @if($opportunity->volunteers_registered > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">⚠️ Warning</h3>
                    <p class="text-sm text-yellow-700">
                        This opportunity has {{ $opportunity->volunteers_registered }} registered volunteer(s). 
                        Be careful when making major changes.
                    </p>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                        Update Opportunity
                    </button>
                    <a href="{{ route('organization.opportunities.show', $opportunity->opportunity_id) }}" 
                       class="block w-full px-6 py-3 text-center border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        Cancel
                    </a>
                    <button type="button"
                            onclick="confirmDelete()"
                            class="w-full px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                        Delete Opportunity
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Delete Opportunity</h3>
        <p class="text-gray-600 mb-6">
            Are you sure you want to delete this opportunity? 
            @if($opportunity->volunteers_registered > 0)
            <strong class="text-red-600">{{ $opportunity->volunteers_registered }} volunteer(s) are currently registered.</strong>
            @endif
            This action cannot be undone.
        </p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" 
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Cancel
            </button>
            <form action="{{ route('organization.opportunities.destroy', $opportunity->opportunity_id) }}" 
                  method="POST" 
                  class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('editOpportunityForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect || '{{ route("organization.opportunities.show", $opportunity->opportunity_id) }}';
        } else {
            alert(data.message || 'Failed to update opportunity');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});

function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Date validation
document.querySelector('[name="end_date"]').addEventListener('change', function() {
    const startDate = document.querySelector('[name="start_date"]').value;
    const endDate = this.value;
    
    if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
        alert('End date must be after start date');
        this.value = '';
    }
});

// Volunteers needed validation
document.querySelector('[name="volunteers_needed"]').addEventListener('change', function() {
    const currentRegistered = {{ $opportunity->volunteers_registered }};
    const newValue = parseInt(this.value);
    
    if (newValue < currentRegistered) {
        if (!confirm(`Warning: ${currentRegistered} volunteers are already registered. Setting a lower limit may cause issues. Continue?`)) {
            this.value = {{ $opportunity->volunteers_needed }};
        }
    }
});
</script>
@endpush