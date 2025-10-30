@extends('layouts.organization')

@section('title', 'Verification Request')
@section('breadcrumb', 'Verification Request')

@section('content')
<div class="max-w-5xl mx-auto">

    <!-- Status Banner -->
    @if($organization->verification_status === 'Verified')
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-3xl text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-green-800 dark:text-green-300">Your organization is verified!</h3>
                    <p class="text-green-700 dark:text-green-400 mt-1">You have earned the verified badge. This will be displayed on your profile and all opportunities.</p>
                </div>
            </div>
        </div>
    @elseif($organization->verification_status === 'Pending')
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-3xl text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-yellow-800 dark:text-yellow-300">Verification pending</h3>
                    <p class="text-yellow-700 dark:text-yellow-400 mt-1">Your verification request is under review. Our team will review your documents within 3-5 business days.</p>
                </div>
            </div>
        </div>
    @elseif($organization->verification_status === 'Rejected')
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                    <i class="fas fa-times-circle text-3xl text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-red-800 dark:text-red-300">Verification rejected</h3>
                    <p class="text-red-700 dark:text-red-400 mt-1">Your previous verification request was rejected. Please review the requirements and submit again with correct documents.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Benefits of Verification -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <i class="fas fa-award text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Why Get Verified?</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Build Trust</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Show volunteers you're legitimate</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Higher Visibility</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Appear higher in search results</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">More Applications</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Get 3x more volunteer applications</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">Verified Badge</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Blue checkmark on all your posts</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Form -->
            @if($organization->verification_status !== 'Verified' && $organization->verification_status !== 'Pending')
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-file-upload text-green-600 mr-3"></i>
                    Submit Verification Documents
                </h2>

                <form id="verificationForm" class="space-y-6">
                    @csrf

                    <!-- Document Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Legal Documents <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                            Upload one or more of the following:
                        </p>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 list-disc list-inside mb-4 space-y-1">
                            <li>Business Registration Certificate</li>
                            <li>Operating License</li>
                            <li>Tax Registration Certificate</li>
                            <li>NGO/NPO Registration Certificate</li>
                        </ul>

                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center hover:border-green-500 transition"
                             id="dropzone">
                            <input type="file" id="documents" name="documents[]" 
                                   accept=".pdf,.jpg,.jpeg,.png" 
                                   multiple 
                                   class="hidden">
                            <label for="documents" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-3 block"></i>
                                <p class="text-gray-700 dark:text-gray-300 font-medium">Click to upload or drag and drop</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    PDF, JPG, PNG up to 5MB (Max 5 files)
                                </p>
                            </label>
                        </div>

                        <div id="fileList" class="mt-4 space-y-2"></div>
                        <p class="text-red-500 text-sm mt-1 hidden" id="error-documents"></p>
                    </div>

                    <!-- Contact Verification -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Business Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="business_email" 
                                   value="{{ $organization->user->email }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="official@organization.com">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Must be official domain email</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" 
                                   value="{{ $organization->user->phone }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="0912345678">
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Additional Information
                        </label>
                        <textarea name="additional_info" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Any additional information to support your verification..."></textarea>
                    </div>

                    <!-- Terms Agreement -->
                    <div class="flex items-start space-x-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <input type="checkbox" id="terms" name="terms" required
                               class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <label for="terms" class="text-sm text-gray-700 dark:text-gray-300">
                            I confirm that all information provided is accurate and I understand that providing false information may result in account suspension.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('organization.profile.show') }}" 
                           class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center space-x-2">
                            <i class="fas fa-paper-plane"></i>
                            <span>Submit for Verification</span>
                        </button>
                    </div>
                </form>
            </div>
            @endif

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">

            <!-- Process Timeline -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-tasks text-green-600 mr-2"></i>
                    Verification Process
                </h3>

                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-green-600 dark:text-green-400">1</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white text-sm">Submit Documents</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Upload required legal documents</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-400">2</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white text-sm">Admin Review</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Takes 3-5 business days</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-400">3</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white text-sm">Verification</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">May require additional info</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-400">4</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white text-sm">Get Badge</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Receive verified badge!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requirements Checklist -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl shadow p-6 border border-blue-200 dark:border-blue-800">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-clipboard-check text-blue-600 mr-2"></i>
                    Requirements
                </h3>

                <ul class="space-y-2 text-sm">
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-check text-green-500 mt-1"></i>
                        <span class="text-gray-700 dark:text-gray-300">Valid legal documents</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-check text-green-500 mt-1"></i>
                        <span class="text-gray-700 dark:text-gray-300">Official email address</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-check text-green-500 mt-1"></i>
                        <span class="text-gray-700 dark:text-gray-300">Verified phone number</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-check text-green-500 mt-1"></i>
                        <span class="text-gray-700 dark:text-gray-300">Complete profile information</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-check text-green-500 mt-1"></i>
                        <span class="text-gray-700 dark:text-gray-300">Active for at least 7 days</span>
                    </li>
                </ul>
            </div>

            <!-- Help & Support -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i class="fas fa-question-circle text-green-600 mr-2"></i>
                    Need Help?
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Have questions about verification?
                </p>
                <a href="mailto:support@volunteerconnect.com" 
                   class="inline-flex items-center space-x-2 text-green-600 dark:text-green-400 hover:underline text-sm">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Support</span>
                </a>
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
// File upload handling
const fileInput = document.getElementById('documents');
const fileList = document.getElementById('fileList');
const dropzone = document.getElementById('dropzone');
let selectedFiles = [];

// Click to upload
fileInput?.addEventListener('change', handleFiles);

// Drag and drop
dropzone?.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-green-500', 'bg-green-50');
});

dropzone?.addEventListener('dragleave', () => {
    dropzone.classList.remove('border-green-500', 'bg-green-50');
});

dropzone?.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-green-500', 'bg-green-50');
    
    const files = Array.from(e.dataTransfer.files);
    handleFilesArray(files);
});

function handleFiles(e) {
    const files = Array.from(e.target.files);
    handleFilesArray(files);
}

function handleFilesArray(files) {
    // Validate max 5 files
    if (selectedFiles.length + files.length > 5) {
        showToast('Maximum 5 files allowed', 'error');
        return;
    }

    files.forEach(file => {
        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            showToast(`${file.name} is too large. Max 5MB`, 'error');
            return;
        }

        // Validate file type
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            showToast(`${file.name} is not a supported file type`, 'error');
            return;
        }

        selectedFiles.push(file);
    });

    displayFiles();
}

function displayFiles() {
    fileList.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const fileItem = document.createElement('div');
        fileItem.className = 'flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-3';
        fileItem.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas fa-file-${getFileIcon(file.type)} text-2xl text-gray-400"></i>
                <div>
                    <p class="text-sm font-medium text-gray-800 dark:text-white">${file.name}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024).toFixed(1)} KB</p>
                </div>
            </div>
            <button type="button" onclick="removeFile(${index})" 
                    class="text-red-500 hover:text-red-700">
                <i class="fas fa-times"></i>
            </button>
        `;
        fileList.appendChild(fileItem);
    });
}

function getFileIcon(type) {
    if (type === 'application/pdf') return 'pdf';
    if (type.startsWith('image/')) return 'image';
    return 'file';
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    displayFiles();
}

// Form submission
document.getElementById('verificationForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (selectedFiles.length === 0) {
        showToast('Please upload at least one document', 'error');
        return;
    }
    
    const formData = new FormData(this);
    
    // Add files to FormData
    selectedFiles.forEach(file => {
        formData.append('documents[]', file);
    });
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
    
    try {
        const response = await fetch('{{ route("organization.verification.submit") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToast('Verification request submitted successfully!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showToast(data.message || 'Failed to submit request', 'error');
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