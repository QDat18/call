<div class="modal fade" id="newCallModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-video me-2 text-primary"></i>Start New Call
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="position-relative mb-4 mt-2">
                    <i class="fas fa-search position-absolute text-muted" style="left: 15px; top: 12px;"></i>
                    <input type="text" class="form-control form-control-lg ps-5 bg-light border-0" 
                           placeholder="Search people or phone numbers..." id="searchFriends">
                </div>

                <h6 class="text-muted text-uppercase small fw-bold mb-3">Suggested Contacts</h6>
                <div class="friends-call-list custom-scrollbar" id="friendsList" style="max-height: 400px; overflow-y: auto;">
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-circle-notch fa-spin me-2"></i> Loading contacts...
                    </div>
                    
                    </div>
            </div>
        </div>
    </div>
</div>