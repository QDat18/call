@extends('layouts.app')

@section('title', 'Friends')

@section('content')
    <div class="container-fluid" style="background-color: #f0f2f5; min-height: 100vh;">
        <div class="row g-0">
            <!-- Left Sidebar -->
            <div class="col-md-3 col-lg-3">
                <div class="left-sidebar">
                    <div class="sidebar-header">
                        <h2>Friends</h2>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="sidebar-menu">
                        <a href="{{ route('connections.index', ['status' => 'accepted']) }}"
                            class="menu-item {{ $status === 'accepted' ? 'active' : '' }}">
                            <div class="menu-icon-wrapper">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div class="menu-content">
                                <span class="menu-text">All Friends</span>
                                <span class="menu-badge">{{ $acceptedCount }}</span>
                            </div>
                        </a>

                        <a href="{{ route('connections.index', ['status' => 'pending']) }}"
                            class="menu-item {{ $status === 'pending' ? 'active' : '' }}">
                            <div class="menu-icon-wrapper">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div class="menu-content">
                                <span class="menu-text">Friend Requests</span>
                                @if($pendingCount > 0)
                                    <span class="menu-badge notification">{{ $pendingCount }}</span>
                                @endif
                            </div>
                        </a>

                        <a href="{{ route('connections.index', ['status' => 'blocked']) }}"
                            class="menu-item {{ $status === 'blocked' ? 'active' : '' }}">
                            <div class="menu-icon-wrapper">
                                <i class="fas fa-ban"></i>
                            </div>
                            <div class="menu-content">
                                <span class="menu-text">Blocked</span>
                            </div>
                        </a>
                    </div>

                    <!-- Search Section -->
                    <div class="search-section">
                        <div class="search-box">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="search-users" placeholder="Search friends..." autocomplete="off">
                        </div>
                        <div id="search-results" class="search-results" style="display:none;">
                            <div id="user-list"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9 col-lg-9">
                <div class="main-content">
                    <!-- Header -->
                    <div class="content-header">
                        <h3>
                            @if($status === 'accepted')
                                All Friends
                            @elseif($status === 'pending')
                                Friend Requests
                            @else
                                Blocked Users
                            @endif
                        </h3>
                        <p class="text-muted">
                            @if($status === 'accepted')
                                {{ $acceptedCount }} {{ $acceptedCount == 1 ? 'friend' : 'friends' }}
                            @elseif($status === 'pending')
                                {{ $pendingCount }} {{ $pendingCount == 1 ? 'request' : 'requests' }}
                            @endif
                        </p>
                    </div>

                    <!-- Friends Grid -->
                    @if($connections->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <h4>No {{ $status === 'accepted' ? 'friends' : ($status === 'pending' ? 'requests' : 'blocked users') }} yet</h4>
                            @if($status === 'accepted')
                                <p class="text-muted">Search for people you know and add them as friends.</p>
                                <button class="btn-fb-primary" onclick="$('#search-users').focus()">
                                    <i class="fas fa-user-plus me-2"></i> Find Friends
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="friends-grid">
                            @foreach($connections as $connection)
                                @php
                                    $friend = $connection->user_id === auth()->id() ? $connection->friend : $connection->user;
                                    $isSender = $connection->user_id === auth()->id();
                                @endphp
                                <div class="friend-card" id="connection-{{ $connection->connection_id }}">
                                    <div class="friend-card-inner">
                                        <a href="{{ route('users.profile', $friend->user_id) }}" class="friend-avatar-link">
                                            <img src="{{ $friend->avatar_url ? (filter_var($friend->avatar_url, FILTER_VALIDATE_URL) ? $friend->avatar_url : asset('storage/' . $friend->avatar_url)) : asset('images/default-avatar.png') }}"
                                                class="friend-avatar"
                                                alt="{{ $friend->first_name }}"
                                                onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                        </a>
                                        <div class="friend-info">
                                            <a href="{{ route('users.profile', $friend->user_id) }}" class="friend-name">
                                                {{ $friend->first_name }} {{ $friend->last_name }}
                                            </a>
                                            <p class="friend-meta">
                                                {{ ucfirst($friend->user_type) }}@if($friend->city) · {{ $friend->city }}@endif
                                            </p>
                                        </div>
                                        <div class="friend-actions">
                                            @if($status === 'accepted')
                                                <a href="{{ route('conversations.create', ['user_id' => $friend->user_id]) }}"
                                                    class="btn-fb-secondary">
                                                    <i class="fas fa-comment me-1"></i> Message
                                                </a>
                                                <div class="dropdown">
                                                    <button class="btn-fb-more" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); removeFriend({{ $connection->connection_id }})">
                                                            <i class="fas fa-user-times me-2"></i> Unfriend
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            @elseif($status === 'pending')
                                                @if($isSender)
                                                    <button class="btn-fb-secondary" onclick="cancelRequest({{ $connection->connection_id }})">
                                                        <i class="fas fa-user-clock me-1"></i> Cancel Request
                                                    </button>
                                                @else
                                                    <button class="btn-fb-primary" onclick="acceptRequest({{ $connection->connection_id }})">
                                                        <i class="fas fa-check me-1"></i> Confirm
                                                    </button>
                                                    <button class="btn-fb-secondary" onclick="declineRequest({{ $connection->connection_id }})">
                                                        <i class="fas fa-times me-1"></i> Delete
                                                    </button>
                                                @endif
                                            @elseif($status === 'blocked')
                                                <button class="btn-fb-primary" onclick="unblockUser({{ $connection->connection_id }})">
                                                    <i class="fas fa-unlock me-1"></i> Unblock
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-wrapper">
                            {{ $connections->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Facebook Colors */
        :root {
            --fb-blue: #1877f2;
            --fb-hover-blue: #166fe5;
            --fb-light-gray: #f0f2f5;
            --fb-medium-gray: #e4e6eb;
            --fb-dark-gray: #050505;
            --fb-secondary-text: #65676b;
            --fb-border: #ced0d4;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--fb-light-gray) !important;
        }

        /* Left Sidebar */
        .left-sidebar {
            position: sticky;
            top: 60px;
            height: calc(100vh - 60px);
            background: white;
            border-right: 1px solid var(--fb-medium-gray);
            padding: 16px 8px;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 0 8px 16px;
        }

        .sidebar-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--fb-dark-gray);
            margin: 0;
        }

        /* Sidebar Menu */
        .sidebar-menu {
            margin-bottom: 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 4px;
            text-decoration: none;
            color: var(--fb-dark-gray);
            transition: background-color 0.2s;
            cursor: pointer;
        }

        .menu-item:hover {
            background-color: var(--fb-light-gray);
        }

        .menu-item.active {
            background-color: #e7f3ff;
            color: var(--fb-blue);
        }

        .menu-icon-wrapper {
            width: 36px;
            height: 36px;
            background-color: var(--fb-medium-gray);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .menu-item.active .menu-icon-wrapper {
            background-color: var(--fb-blue);
            color: white;
        }

        .menu-icon-wrapper i {
            font-size: 18px;
        }

        .menu-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex: 1;
        }

        .menu-text {
            font-size: 15px;
            font-weight: 500;
        }

        .menu-badge {
            background-color: var(--fb-medium-gray);
            color: var(--fb-secondary-text);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
        }

        .menu-badge.notification {
            background-color: #e41e3f;
            color: white;
        }

        /* Search Section */
        .search-section {
            padding: 8px;
            border-top: 1px solid var(--fb-medium-gray);
            padding-top: 16px;
        }

        .search-box {
            position: relative;
            width: 100%;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--fb-secondary-text);
            font-size: 14px;
        }

        .search-box input {
            width: 100%;
            padding: 8px 12px 8px 36px;
            border: none;
            background-color: var(--fb-light-gray);
            border-radius: 20px;
            font-size: 15px;
            outline: none;
        }

        .search-box input:focus {
            background-color: var(--fb-medium-gray);
        }

        .search-results {
            margin-top: 8px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-height: 400px;
            overflow-y: auto;
        }

        .user-search-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-bottom: 1px solid var(--fb-light-gray);
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .user-search-item:hover {
            background-color: var(--fb-light-gray);
        }

        .user-search-item:last-child {
            border-bottom: none;
        }

        /* Main Content */
        .main-content {
            padding: 24px 32px;
            max-width: 1096px;
        }

        .content-header {
            margin-bottom: 24px;
        }

        .content-header h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--fb-dark-gray);
            margin-bottom: 4px;
        }

        /* Empty State */
        .empty-state {
            background: white;
            border-radius: 8px;
            padding: 60px 40px;
            text-align: center;
        }

        .empty-icon {
            width: 112px;
            height: 112px;
            background: var(--fb-light-gray);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .empty-icon i {
            font-size: 48px;
            color: var(--fb-secondary-text);
        }

        .empty-state h4 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--fb-dark-gray);
        }

        /* Friends Grid */
        .friends-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }

        .friend-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
        }

        .friend-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .friend-card-inner {
            padding: 12px;
        }

        .friend-avatar-link {
            display: block;
            margin-bottom: 12px;
        }

        .friend-avatar {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 8px;
        }

        .friend-info {
            margin-bottom: 12px;
        }

        .friend-name {
            display: block;
            font-size: 17px;
            font-weight: 600;
            color: var(--fb-dark-gray);
            text-decoration: none;
            margin-bottom: 4px;
        }

        .friend-name:hover {
            text-decoration: underline;
        }

        .friend-meta {
            font-size: 13px;
            color: var(--fb-secondary-text);
            margin: 0;
        }

        .friend-actions {
            display: flex;
            gap: 8px;
        }

        /* Facebook Buttons */
        .btn-fb-primary {
            flex: 1;
            padding: 8px 12px;
            background-color: var(--fb-blue);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-fb-primary:hover {
            background-color: var(--fb-hover-blue);
            color: white;
        }

        .btn-fb-secondary {
            flex: 1;
            padding: 8px 12px;
            background-color: var(--fb-medium-gray);
            color: var(--fb-dark-gray);
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-fb-secondary:hover {
            background-color: #d8dadf;
            color: var(--fb-dark-gray);
        }

        .btn-fb-more {
            width: 36px;
            height: 36px;
            padding: 0;
            background-color: var(--fb-medium-gray);
            color: var(--fb-secondary-text);
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-fb-more:hover {
            background-color: #d8dadf;
        }

        /* Friend Options Menu - using Bootstrap dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 8px 0;
            min-width: 200px;
        }

        .dropdown-item {
            padding: 10px 16px;
            font-size: 15px;
            color: var(--fb-dark-gray);
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: var(--fb-light-gray);
            color: var(--fb-dark-gray);
        }

        .dropdown-item i {
            width: 24px;
            color: var(--fb-secondary-text);
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }

        /* Scrollbar */
        .left-sidebar::-webkit-scrollbar,
        .search-results::-webkit-scrollbar {
            width: 8px;
        }

        .left-sidebar::-webkit-scrollbar-track,
        .search-results::-webkit-scrollbar-track {
            background: transparent;
        }

        .left-sidebar::-webkit-scrollbar-thumb,
        .search-results::-webkit-scrollbar-thumb {
            background: var(--fb-border);
            border-radius: 4px;
        }

        .left-sidebar::-webkit-scrollbar-thumb:hover,
        .search-results::-webkit-scrollbar-thumb:hover {
            background: var(--fb-secondary-text);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .left-sidebar {
                position: relative;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--fb-medium-gray);
            }

            .main-content {
                padding: 16px;
            }

            .friends-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 12px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Live Search
        let searchTimeout;
        document.getElementById('search-users').addEventListener('input', e => {
            clearTimeout(searchTimeout);
            const query = e.target.value.trim();
            if (query.length < 2) {
                document.getElementById('search-results').style.display = 'none';
                return;
            }
            searchTimeout = setTimeout(() => searchUsers(query), 400);
        });

        function searchUsers(query) {
            fetch(`/connections/search?q=${encodeURIComponent(query)}`, {
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
                .then(res => res.json())
                .then(data => {
                    const resultsDiv = document.getElementById('search-results');
                    const userList = document.getElementById('user-list');
                    if (data.success && data.users.length) {
                        userList.innerHTML = data.users.map(user => `
                        <div class="user-search-item">
                            <div class="d-flex align-items-center">
                                <img src="${user.avatar_url || '/images/default-avatar.png'}" 
                                     class="rounded-circle me-2" 
                                     style="width:40px;height:40px;object-fit:cover;">
                                <div>
                                    <strong style="font-size: 15px; color: var(--fb-dark-gray);">${user.first_name} ${user.last_name}</strong><br>
                                    <small style="color: var(--fb-secondary-text);">${user.user_type}</small>
                                </div>
                            </div>
                            <div>${getConnectionButton(user)}</div>
                        </div>
                    `).join('');
                    } else {
                        userList.innerHTML = '<div class="text-center py-3" style="color: var(--fb-secondary-text);">No users found</div>';
                    }
                    resultsDiv.style.display = 'block';
                });
        }

        function getConnectionButton(user) {
            switch (user.connection_status) {
                case 'accepted':
                    return '<span class="badge" style="background-color: var(--fb-medium-gray); color: var(--fb-secondary-text); padding: 6px 12px; border-radius: 6px;"><i class="fas fa-check me-1"></i> Friends</span>';
                case 'pending':
                    return user.is_sender
                        ? '<span class="badge" style="background-color: var(--fb-medium-gray); color: var(--fb-secondary-text); padding: 6px 12px; border-radius: 6px;"><i class="fas fa-clock me-1"></i> Pending</span>'
                        : `<button class="btn-fb-primary" style="padding: 6px 12px; font-size: 14px;" onclick="acceptRequest(${user.connection_id})"><i class="fas fa-check me-1"></i> Confirm</button>`;
                case 'blocked':
                    return '<span class="badge bg-danger" style="padding: 6px 12px; border-radius: 6px;"><i class="fas fa-ban me-1"></i> Blocked</span>';
                default:
                    return `<button class="btn-fb-primary" style="padding: 6px 12px; font-size: 14px;" onclick="sendFriendRequest(${user.user_id})"><i class="fas fa-user-plus me-1"></i> Add Friend</button>`;
            }
        }

        // Connection Actions
        function handleConnectionAction(id, endpoint, method, successMsg) {
            const cardElement = document.getElementById(`connection-${id}`);
            if (!cardElement) return;

            fetch(endpoint, {
                method: method,
                headers: { 'X-CSRF-TOKEN': csrfToken },
            })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {
                        showToast('success', successMsg);
                        cardElement.style.opacity = '0';
                        setTimeout(() => cardElement.remove(), 300);
                    } else {
                        showToast('error', d.message || 'Operation failed.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    showToast('error', 'Network error.');
                });
        }

        function acceptRequest(id) {
            handleConnectionAction(id, `/connections/${id}/accept`, 'POST', 'Friend request accepted!');
        }

        function declineRequest(id) {
            handleConnectionAction(id, `/connections/${id}/decline`, 'POST', 'Friend request deleted.');
        }

        function cancelRequest(id) {
            handleConnectionAction(id, `/connections/${id}/decline`, 'POST', 'Friend request cancelled.');
        }

        function removeFriend(id) {
            if (!confirm('Are you sure you want to unfriend this person?')) return;
            handleConnectionAction(id, `/connections/${id}/remove`, 'DELETE', 'Friend removed.');
        }

        function unblockUser(id) {
            handleConnectionAction(id, `/connections/${id}/unblock`, 'POST', 'User unblocked.');
        }

        // Toast Notification
        function showToast(type, msg) {
            const colors = { success: '#31a24c', error: '#e41e3f', info: '#1877f2', warning: '#f5a623' };
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
                document.body.appendChild(container);
            }
            
            const toast = document.createElement('div');
            toast.style.cssText = 'background: ' + colors[type] + '; color: white; padding: 12px 20px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 15px; font-weight: 500; min-width: 300px; opacity: 0; transition: opacity 0.3s;';
            toast.textContent = msg;
            container.appendChild(toast);
            
            setTimeout(function() { toast.style.opacity = '1'; }, 10);
            setTimeout(function() {
                toast.style.opacity = '0';
                setTimeout(function() { toast.remove(); }, 300);
            }, 3000);
        }
        })();
    </script>
@endpush