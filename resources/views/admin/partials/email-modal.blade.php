<div id="emailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="backdrop-filter: blur(2px);">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-envelope text-indigo-600 mr-2"></i>Compose Email
            </h3>
            <button onclick="closeEmailModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <form id="emailForm" action="{{ route('admin.emails.send') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Recipients</label>
                <input type="hidden" name="recipient_type" id="recipientType">
                <input type="hidden" name="user_id" id="userId">
                <div id="recipientInfo" class="p-3 bg-gray-50 rounded-lg text-sm text-gray-700 flex items-center">
                    <i class="fas fa-users text-gray-400 mr-2"></i>
                    <span id="recipientText">All Users</span>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                <input type="text" id="subject" name="subject" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                       placeholder="Enter email subject">
            </div>
            
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                <textarea id="message" name="message" rows="8" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                          placeholder="Write your message here... (You can use {name} placeholder)"></textarea>
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeEmailModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i>Send Email
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEmailModal(type, userId = null) {
        const modal = document.getElementById('emailModal');
        const recipientType = document.getElementById('recipientType');
        const userIdInput = document.getElementById('userId');
        const recipientText = document.getElementById('recipientText');

        recipientType.value = type;
        userIdInput.value = userId || '';
        
        let text = '';
        switch(type) {
            case 'all': text = 'All Users'; break;
            case 'volunteers': text = 'All Volunteers'; break;
            case 'organizations': text = 'All Organizations'; break;
            case 'single': text = 'Single User (ID: ' + userId + ')'; break;
        }
        recipientText.innerText = text;
        recipientText.innerHTML = `<strong>${text}</strong>`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeEmailModal() {
        const modal = document.getElementById('emailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Form Submit Logic
    document.getElementById('emailForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';

        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if(typeof showToast === 'function') showToast('Email sent successfully!', 'success');
                else alert('Email sent successfully!');
                closeEmailModal();
            } else {
                if(typeof showToast === 'function') showToast(data.message, 'error');
                else alert(data.message);
            }
        })
        .catch(error => {
            console.error(error);
            if(typeof showToast === 'function') showToast('An error occurred', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    });
</script>