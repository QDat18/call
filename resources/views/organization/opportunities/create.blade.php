@extends('layouts.organization')

@section('title', 'Create Opportunity')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('organization.opportunities.index') }}"
                class="inline-flex items-center gap-2 text-green-600 hover:text-green-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Opportunities
            </a>
        </div>

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Create New Opportunity</h1>
            <p class="text-gray-600 mt-1">Fill in the details to create a volunteer opportunity</p>
        </div>

        <form id="opportunityForm" method="POST" action="{{ route('organization.opportunities.store') }}" class="space-y-6">
            @csrf

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
                                <input type="text" name="title" required maxlength="200"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="e.g., Teach English to Underprivileged Children">
                                <p class="text-sm text-gray-500 mt-1">Create a clear, descriptive title (max 200 characters)
                                </p>
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select name="category_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" required rows="6"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="Describe the volunteer opportunity in detail..."></textarea>
                                <p class="text-sm text-gray-500 mt-1">Provide a detailed description of what volunteers will
                                    do</p>
                            </div>

                            <!-- Requirements -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Requirements
                                </label>
                                <textarea name="requirements" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="List any specific requirements or qualifications needed..."></textarea>
                            </div>

                            <!-- Benefits -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Benefits
                                </label>
                                <textarea name="benefits" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="What benefits will volunteers receive? (e.g., certificate, training, meals)"></textarea>
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
                                <input type="date" name="start_date" min="{{ date('Y-m-d', strtotime('+3 days')) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <!-- End Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    End Date
                                </label>
                                <input type="date" name="end_date"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <!-- Time Commitment -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Time Commitment
                                </label>
                                <select name="time_commitment"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="1-2 hours">1-2 hours</option>
                                    <option value="3-5 hours">3-5 hours</option>
                                    <option value="6-8 hours">6-8 hours</option>
                                    <option value="Full day">Full day</option>
                                    <option value="Multiple days">Multiple days</option>
                                </select>
                            </div>

                            <!-- Schedule Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Schedule Type
                                </label>
                                <select name="schedule_type"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="One-time">One-time</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Flexible">Flexible</option>
                                </select>
                            </div>

                            <!-- Location -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Location <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="location" required maxlength="200"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="e.g., 123 Main Street, Hanoi">
                            </div>

                            <!-- Application Deadline -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Application Deadline
                                </label>
                                <input type="date" name="application_deadline" min="{{ date('Y-m-d') }}"
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
                                <input type="number" name="volunteers_needed" required min="1" value="1"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <!-- Minimum Age -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Minimum Age
                                </label>
                                <input type="number" name="min_age" min="16" value="16"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <!-- Experience Needed -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Experience Level
                                </label>
                                <select name="experience_needed"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="No experience">No experience required</option>
                                    <option value="Some experience">Some experience preferred</option>
                                    <option value="Experienced">Experienced volunteers only</option>
                                </select>
                            </div>

                            <!-- Required Skills -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Required Skills
                                </label>
                                <select id="required_skills" name="required_skills[]" multiple
                                    placeholder="Select skills or type to add new ones..." autocomplete="off">
                                    <option value="">Select skills...</option>
                                    {{-- Danh sách kỹ năng gợi ý --}}
                                    <option value="Communication">Communication</option>
                                    <option value="Teamwork">Teamwork</option>
                                    <option value="Leadership">Leadership</option>
                                    <option value="Teaching">Teaching</option>
                                    <option value="English">English</option>
                                    <option value="Event Planning">Event Planning</option>
                                    <option value="Fundraising">Fundraising</option>
                                    <option value="Graphic Design">Graphic Design</option>
                                    <option value="Social Media">Social Media</option>
                                    <option value="First Aid">First Aid</option>
                                    <option value="Photography">Photography</option>
                                    <option value="Cooking">Cooking</option>
                                    <option value="Driving">Driving</option>
                                    <option value="IT Support">IT Support</option>
                                    <option value="Counseling">Counseling</option>
                                </select>
                                <p class="text-sm text-gray-500 mt-1">Select from the list or type to create a new skill.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Preview Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Preview</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Fill in all required fields</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Review before publishing</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Opportunity will be Active</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-3">💡 Tips for Success</h3>
                        <ul class="space-y-2 text-sm text-blue-700">
                            <li class="flex gap-2">
                                <span>•</span>
                                <span>Use clear, descriptive titles</span>
                            </li>
                            <li class="flex gap-2">
                                <span>•</span>
                                <span>Be specific about requirements</span>
                            </li>
                            <li class="flex gap-2">
                                <span>•</span>
                                <span>Highlight the impact volunteers will make</span>
                            </li>
                            <li class="flex gap-2">
                                <span>•</span>
                                <span>Include benefits and incentives</span>
                            </li>
                            <li class="flex gap-2">
                                <span>•</span>
                                <span>Set realistic time commitments</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button type="submit"
                            class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                            Create Opportunity
                        </button>
                        <a href="{{ route('organization.opportunities.index') }}"
                            class="block w-full px-6 py-3 text-center border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
// 1. Bảng màu sinh động (Pastel đậm hơn chút để dễ nhìn trong ô input)
const tagColors = [
    'bg-red-100 text-red-700 border-red-200',
    'bg-orange-100 text-orange-700 border-orange-200',
    'bg-amber-100 text-amber-700 border-amber-200',
    'bg-green-100 text-green-700 border-green-200',
    'bg-emerald-100 text-emerald-700 border-emerald-200',
    'bg-teal-100 text-teal-700 border-teal-200',
    'bg-cyan-100 text-cyan-700 border-cyan-200',
    'bg-sky-100 text-sky-700 border-sky-200',
    'bg-blue-100 text-blue-700 border-blue-200',
    'bg-indigo-100 text-indigo-700 border-indigo-200',
    'bg-violet-100 text-violet-700 border-violet-200',
    'bg-purple-100 text-purple-700 border-purple-200',
    'bg-fuchsia-100 text-fuchsia-700 border-fuchsia-200',
    'bg-pink-100 text-pink-700 border-pink-200',
    'bg-rose-100 text-rose-700 border-rose-200',
];

// Hàm chọn màu dựa trên ký tự
function getSkillColor(text) {
    if (!text) return tagColors[0];
    let hash = 0;
    for (let i = 0; i < text.length; i++) {
        hash = text.charCodeAt(i) + ((hash << 5) - hash);
    }
    const index = Math.abs(hash % tagColors.length);
    return tagColors[index];
}

// 2. Khởi tạo Tom Select
var skillSelect = new TomSelect("#required_skills", {
    create: true,
    sortField: { field: "text", direction: "asc" },
    plugins: ['remove_button'], // Plugin xóa tag
    maxItems: 10,
    persist: false,
    
    render: {
        // --- HIỂN THỊ TRONG Ô INPUT (Cái bạn cần) ---
        item: function(data, escape) {
            const colorClass = getSkillColor(data.text);
            
            // Trả về div có class màu sắc của Tailwind
            // Tom Select sẽ tự động chèn nút (x) vào bên trong div này
            return `<div class="${colorClass} rounded-full px-3 py-1 text-sm font-semibold border flex items-center shadow-sm">
                        ${escape(data.text)}
                    </div>`;
        },

        // --- HIỂN THỊ TRONG DANH SÁCH GỢI Ý ---
        option: function(data, escape) {
            const colorClass = getSkillColor(data.text);
            const dotColor = colorClass.split(' ')[0].replace('bg-', 'bg-').replace('100', '400');
            
            return `<div class="px-3 py-2 flex items-center hover:bg-gray-50">
                        <span class="w-2 h-2 rounded-full mr-3 ${dotColor}"></span>
                        <span class="text-gray-700 font-medium">${escape(data.text)}</span>
                    </div>`;
        }
    }
});

// 3. Xử lý Submit Form
document.getElementById('opportunityForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const selectedSkills = skillSelect.getValue();
    
    formData.delete('required_skills[]'); 
    
    if (Array.isArray(selectedSkills)) {
        formData.append('required_skills', selectedSkills.join(', '));
    } else {
        formData.append('required_skills', selectedSkills);
    }
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) window.location.href = data.redirect || '{{ route("organization.opportunities.index") }}';
        else alert(data.message || 'Failed');
    })
    .catch(e => { console.error(e); alert('Error occurred'); });
});

// Date validation
document.querySelector('[name="end_date"]').addEventListener('change', function() {
    const startDate = document.querySelector('[name="start_date"]').value;
    if (startDate && this.value && new Date(this.value) < new Date(startDate)) {
        alert('End date must be after start date');
        this.value = '';
    }
});
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Tùy chỉnh container input */
    .ts-control {
        border-radius: 0.5rem;
        padding: 0.375rem 0.75rem;
        border-color: #d1d5db;
        min-height: 42px; /* Đảm bảo chiều cao không bị nhảy */
        background-image: none !important; /* Xóa icon mũi tên mặc định nếu có */
    }
    
    .ts-control:focus-within {
        box-shadow: 0 0 0 2px #10b981;
        border-color: transparent;
    }

    /* QUAN TRỌNG: Reset style mặc định của item để hiển thị màu Tailwind */
    .ts-wrapper.multi .ts-control > div.item {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        margin: 2px 4px 2px 0 !important;
    }

    /* Tùy chỉnh nút Xóa (x) bên trong tag */
    .ts-wrapper.multi .ts-control > div.item .remove {
        border-left: none !important;
        margin-left: 5px;
        font-size: 14px;
        color: inherit !important; /* Ăn theo màu chữ của tag */
        opacity: 0.6;
    }
    .ts-wrapper.multi .ts-control > div.item .remove:hover {
        background: transparent !important;
        opacity: 1;
    }
</style>
@endpush