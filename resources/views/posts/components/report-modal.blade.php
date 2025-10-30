<!-- resources/views/posts/components/report-modal.blade.php -->
<div id="report-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="relative inline-block w-full max-w-md px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl sm:my-8 sm:align-middle sm:p-6">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        Report Content
                    </h3>
                    <button type="button" onclick="closeReportModal()" 
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form id="report-form" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" id="report-post-id">
                    <input type="hidden" name="comment_id" id="report-comment-id">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Reason for reporting <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2">
                            @php
                                $reportReasons = [
                                    'spam' => 'Spam or misleading content',
                                    'harassment' => 'Harassment or bullying',
                                    'hate_speech' => 'Hate speech or offensive content',
                                    'inappropriate' => 'Inappropriate content',
                                    'false_information' => 'False information',
                                    'other' => 'Other reason'
                                ];
                            @endphp
                            @foreach($reportReasons as $value => $label)
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="reason" value="{{ $value }}" 
                                       class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                       {{ $loop->first ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="report-description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Additional details (optional)
                        </label>
                        <textarea name="description" id="report-description" rows="3" 
                                  placeholder="Please provide any additional information that might help us understand your report..."
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-4">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                            <div class="text-sm text-blue-700 dark:text-blue-300">
                                <p>Your report will be reviewed by our moderation team. We take all reports seriously and will take appropriate action.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button type="button" onclick="closeReportModal()" 
                                class="flex-1 px-4 py-2 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            <i class="fas fa-flag mr-2"></i>Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentReportPostId = null;
let currentReportCommentId = null;

function openReportModal(postId = null, commentId = null) {
    currentReportPostId = postId;
    currentReportCommentId = commentId;
    
    document.getElementById('report-post-id').value = postId || '';
    document.getElementById('report-comment-id').value = commentId || '';
    document.getElementById('report-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeReportModal() {
    document.getElementById('report-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    
    // Reset form
    document.getElementById('report-form').reset();
    currentReportPostId = null;
    currentReportCommentId = null;
}

// Close modal when clicking outside
document.getElementById('report-modal').addEventListener('click', function(e) {
    if (e.target.id === 'report-modal') {
        closeReportModal();
    }
});

// Handle form submission
document.getElementById('report-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const postId = document.getElementById('report-post-id').value;
    
    // Build the correct URL with the post ID
    const url = `/posts/${postId}/report`;
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Report submitted successfully. Thank you for helping keep our community safe.', 'success');
            closeReportModal();
        } else {
            showNotification('There was an error submitting your report. Please try again.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('There was an error submitting your report. Please try again.', 'error');
    });
});

function showNotification(message, type = 'info') {
    // You can implement your notification system here
    // For now, using a simple alert
    alert(message);
}
</script>
@endpush