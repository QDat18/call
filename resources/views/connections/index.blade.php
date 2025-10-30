@extends('layouts.app')

@section('title', 'Friends')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-user-friends text-primary"></i> Friends
                    </h5>

                    <!-- Menu -->
                    <div class="list-group list-group-flush">
                        <a href="{{ route('connections.index', ['status' => 'accepted']) }}" 
                           class="list-group-item list-group-item-action {{ $status === 'accepted' ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i> All Friends
                            <span class="badge bg-primary float-end">{{ $acceptedCount }}</span>
                        </a>
                        <a href="{{ route('connections.index', ['status' => 'pending']) }}" 
                           class="list-group-item list-group-item-action {{ $status === 'pending' ? 'active' : '' }}">
                            <i class="fas fa-user-clock me-2"></i> Friend Requests
                            @if($pendingCount > 0)
                                <span class="badge bg-danger float-end">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('connections.index', ['status' => 'blocked']) }}" 
                           class="list-group-item list-group-item-action {{ $status === 'blocked' ? 'active' : '' }}">
                            <i class="fas fa-user-slash me-2"></i> Blocked Users
                        </a>
                    </div>

                    <!-- Search -->
                    <div class="mt-4">
                        <h6 class="text-muted mb-2"><i class="fas fa-search"></i> Find Friends</h6>
                        <div class="input-group">
                            <input type="text" id="search-users" class="form-control" placeholder="Search by name..." autocomplete="off">
                            <button class="btn btn-primary" type="button" onclick="searchUsers(document.getElementById('search-users').value)">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div id="search-results" class="mt-2" style="display:none;">
                            <div class="list-group" id="user-list"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        @if($status === 'accepted')
                            <i class="fas fa-users text-primary"></i> My Friends ({{ $acceptedCount }})
                        @elseif($status === 'pending')
                            <i class="fas fa-user-clock text-warning"></i> Friend Requests ({{ $pendingCount }})
                        @else
                            <i class="fas fa-user-slash text-danger"></i> Blocked Users
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if($connections->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-user-friends fa-4x mb-3"></i>
                            <h5>No {{ $status === 'accepted' ? 'friends' : ($status === 'pending' ? 'requests' : 'blocked users') }} found</h5>
                            @if($status === 'accepted')
                                <button class="btn btn-primary mt-2" onclick="$('#search-users').focus()">
                                    <i class="fas fa-search me-1"></i> Find Friends
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($connections as $connection)
                                @php
                                    $friend = $connection->user_id === auth()->id() ? $connection->friend : $connection->user;
                                    $isSender = $connection->user_id === auth()->id();
                                @endphp
                                <div class="col-sm-6 col-md-4">
                                    <div class="card h-100 friend-card shadow-sm">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="{{ $friend->avatar_url ?? asset('images/default-avatar.png') }}" class="rounded-circle me-3" style="width:60px;height:60px;object-fit:cover;">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0"><a href="{{ route('users.profile', $friend->user_id) }}" class="text-dark text-decoration-none">{{ $friend->first_name }} {{ $friend->last_name }}</a></h6>
                                                    <small class="text-muted">{{ ucfirst($friend->user_type) }} @if($friend->city) · {{ $friend->city }} @endif</small>
                                                </div>
                                            </div>
                                            <div class="mt-auto">
                                                @if($status === 'accepted')
                                                    <div class="d-flex justify-content-between">
                                                        <a href="{{ route('conversations.create', ['user_id' => $friend->user_id]) }}" class="btn btn-sm btn-outline-primary flex-grow-1 me-1">
                                                            <i class="fas fa-comment me-1"></i> Message
                                                        </a>
                                                        <button class="btn btn-sm btn-outline-danger flex-grow-1 ms-1" onclick="removeFriend({{ $connection->connection_id }})">
                                                            <i class="fas fa-user-times me-1"></i> Unfriend
                                                        </button>
                                                    </div>
                                                @elseif($status === 'pending')
                                                    @if($isSender)
                                                        <button class="btn btn-sm btn-outline-secondary w-100" onclick="cancelRequest({{ $connection->connection_id }})">
                                                            <i class="fas fa-clock me-1"></i> Pending
                                                        </button>
                                                    @else
                                                        <div class="d-grid gap-2">
                                                            <button class="btn btn-sm btn-success" onclick="acceptRequest({{ $connection->connection_id }})"><i class="fas fa-check me-1"></i> Accept</button>
                                                            <button class="btn btn-sm btn-outline-danger" onclick="declineRequest({{ $connection->connection_id }})"><i class="fas fa-times me-1"></i> Decline</button>
                                                        </div>
                                                    @endif
                                                @elseif($status === 'blocked')
                                                    <button class="btn btn-sm btn-success w-100" onclick="unblockUser({{ $connection->connection_id }})"><i class="fas fa-unlock me-1"></i> Unblock</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">{{ $connections->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.friend-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.friend-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15) !important;
}
#search-results {
    max-height: 400px;
    overflow-y: auto;
}
.user-search-item {
    cursor: pointer;
    transition: background 0.2s;
}
.user-search-item:hover {
    background-color: #f1f3f5;
}
</style>
@endpush

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// Live Search
let searchTimeout;
document.getElementById('search-users').addEventListener('input', e => {
    clearTimeout(searchTimeout);
    const query = e.target.value.trim();
    if(query.length < 2) { document.getElementById('search-results').style.display='none'; return; }
    searchTimeout = setTimeout(() => searchUsers(query), 400);
});

function searchUsers(query){
    fetch(`/connections/search?q=${encodeURIComponent(query)}`, {
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept':'application/json' }
    })
    .then(res=>res.json())
    .then(data=>{
        const resultsDiv = document.getElementById('search-results');
        const userList = document.getElementById('user-list');
        if(data.success && data.users.length){
            userList.innerHTML = data.users.map(user => `
                <div class="list-group-item user-search-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="${user.avatar_url || '/images/default-avatar.png'}" class="rounded-circle me-2" style="width:40px;height:40px;object-fit:cover;">
                        <div>
                            <strong>${user.first_name} ${user.last_name}</strong><br>
                            <small class="text-muted">${user.user_type}</small>
                        </div>
                    </div>
                    <div>${getConnectionButton(user)}</div>
                </div>
            `).join('');
        } else {
            userList.innerHTML = '<div class="text-center py-2 text-muted">No users found</div>';
        }
        resultsDiv.style.display = 'block';
    });
}

function getConnectionButton(user){
    switch(user.connection_status){
        case 'accepted': return '<span class="badge bg-success"><i class="fas fa-check me-1"></i> Friends</span>';
        case 'pending': return user.is_sender ? '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Pending</span>'
            : `<button class="btn btn-sm btn-success" onclick="acceptRequest(${user.connection_id})"><i class="fas fa-check me-1"></i> Accept</button>`;
        case 'blocked': return '<span class="badge bg-danger"><i class="fas fa-ban me-1"></i> Blocked</span>';
        default: return `<button class="btn btn-sm btn-primary" onclick="sendFriendRequest(${user.user_id})"><i class="fas fa-user-plus me-1"></i> Add Friend</button>`;
    }
}

// Actions
function sendFriendRequest(id){ fetch('/connections/send-request',{ method:'POST', headers:{'X-CSRF-TOKEN':csrfToken,'Content-Type':'application/json'}, body:JSON.stringify({friend_id:id}) }).then(r=>r.json()).then(d=>{ if(d.success){ showToast('success','Friend request sent!'); searchUsers(document.getElementById('search-users').value);} else showToast('error',d.message); }); }
function acceptRequest(id){ fetch(`/connections/${id}/accept`,{method:'POST',headers:{'X-CSRF-TOKEN':csrfToken}}).then(r=>r.json()).then(d=>{if(d.success) location.reload();});}
function declineRequest(id){ if(!confirm('Decline?')) return; fetch(`/connections/${id}/decline`,{method:'POST',headers:{'X-CSRF-TOKEN':csrfToken}}).then(r=>r.json()).then(d=>{if(d.success) location.reload();});}
function removeFriend(id){ if(!confirm('Remove friend?')) return; fetch(`/connections/${id}/remove`,{method:'DELETE',headers:{'X-CSRF-TOKEN':csrfToken}}).then(r=>r.json()).then(d=>{if(d.success) location.reload();});}
function blockUser(id){ if(!confirm('Block user?')) return; fetch(`/connections/${id}/block`,{method:'POST',headers:{'X-CSRF-TOKEN':csrfToken}}).then(r=>r.json()).then(d=>{if(d.success) location.reload();});}
function unblockUser(id){ fetch(`/connections/${id}/unblock`,{method:'POST',headers:{'X-CSRF-TOKEN':csrfToken}}).then(r=>r.json()).then(d=>{if(d.success) location.reload();});}

// Toast
function showToast(type,msg){
    const icons={success:'fa-check-circle',error:'fa-exclamation-circle',info:'fa-info-circle',warning:'fa-exclamation-triangle'};
    const colors={success:'success',error:'danger',info:'info',warning:'warning'};
    let container=document.getElementById('toast-container'); if(!container){ container=document.createElement('div'); container.id='toast-container'; container.className='toast-container position-fixed bottom-0 end-0 p-3'; document.body.appendChild(container);}
    const toast=document.createElement('div'); toast.className=`toast align-items-center text-white bg-${colors[type]} border-0`; toast.role='alert'; toast.innerHTML=`<div class="d-flex"><div class="toast-body"><i class="fas ${icons[type]} me-2"></i>${msg}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
    container.appendChild(toast); new bootstrap.Toast(toast).show(); toast.addEventListener('hidden.bs.toast',()=>toast.remove());
}
</script>
@endpush
