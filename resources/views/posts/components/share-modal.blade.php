<!-- resources/views/posts/components/share-modal.blade.php -->
<div id="share-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div
            class="relative inline-block w-full max-w-md px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl sm:my-8 sm:align-middle sm:p-6">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        Share Post
                    </h3>
                    <button type="button" onclick="closeShareModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        Share this post with others
                    </p>

                    <!-- Share URL -->
                    <div class="flex items-center space-x-2 mb-4">
                        <input type="text" id="share-url" readonly
                            class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg bg-gray-50">
                        <button type="button" onclick="copyShareUrl()"
                            class="px-3 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>

                    <!-- Social Share Buttons -->
                    <div class="grid grid-cols-4 gap-3 mb-4">
                        <a href="#" id="share-facebook"
                            class="flex flex-col items-center justify-center p-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fab fa-facebook text-lg mb-1"></i>
                            <span class="text-xs">Facebook</span>
                        </a>
                        <a href="#" id="share-twitter"
                            class="flex flex-col items-center justify-center p-3 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition">
                            <i class="fab fa-twitter text-lg mb-1"></i>
                            <span class="text-xs">Twitter</span>
                        </a>
                        <a href="#" id="share-linkedin"
                            class="flex flex-col items-center justify-center p-3 bg-blue-800 text-white rounded-lg hover:bg-blue-900 transition">
                            <i class="fab fa-linkedin text-lg mb-1"></i>
                            <span class="text-xs">LinkedIn</span>
                        </a>
                        <a href="#" id="share-whatsapp"
                            class="flex flex-col items-center justify-center p-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                            <i class="fab fa-whatsapp text-lg mb-1"></i>
                            <span class="text-xs">WhatsApp</span>
                        </a>
                    </div>

                    <!-- Email Share -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Share via Email
                        </label>
                        <div class="flex space-x-2">
                            <input type="email" id="share-email" placeholder="Enter email address"
                                class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <button type="button" onclick="shareViaEmail()"
                                class="px-4 py-2 text-sm bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                Send
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeShareModal()"
                        class="px-4 py-2 text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        if (typeof currentShareUrl === 'undefined') {
            var currentShareUrl = '';
        }
        function openShareModal(postId, postTitle = '') {
            currentShareUrl = `${window.location.origin}/posts/${postId}`;
            document.getElementById('share-url').value = currentShareUrl;

            // Set up social sharing links
            const encodedUrl = encodeURIComponent(currentShareUrl);
            const encodedTitle = encodeURIComponent(postTitle || 'Check out this post');

            document.getElementById('share-facebook').href = `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`;
            document.getElementById('share-twitter').href = `https://twitter.com/intent/tweet?url=${encodedUrl}&text=${encodedTitle}`;
            document.getElementById('share-linkedin').href = `https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`;
            document.getElementById('share-whatsapp').href = `https://wa.me/?text=${encodedTitle}%20${encodedUrl}`;

            document.getElementById('share-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeShareModal() {
            document.getElementById('share-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            currentShareUrl = '';
        }

        function copyShareUrl() {
            const urlInput = document.getElementById('share-url');
            urlInput.select();
            urlInput.setSelectionRange(0, 99999);
            document.execCommand('copy');

            // Show copy confirmation
            const originalText = urlInput.value;
            urlInput.value = 'Copied to clipboard!';
            setTimeout(() => {
                urlInput.value = originalText;
            }, 2000);
        }

        function shareViaEmail() {
            const email = document.getElementById('share-email').value;
            if (email) {
                const subject = 'Check out this post from our community';
                const body = `I thought you might be interested in this post: ${currentShareUrl}`;
                window.location.href = `mailto:${email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
            }
        }

        // Close modal when clicking outside
        document.getElementById('share-modal').addEventListener('click', function (e) {
            if (e.target.id === 'share-modal') {
                closeShareModal();
            }
        });
    </script>
@endpush