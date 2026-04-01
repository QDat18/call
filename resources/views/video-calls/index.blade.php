@extends('layouts.app')

@section('title', 'Video Calls')

@section('content')
    <div class="video-calls-messenger">
        <div class="container-fluid">
            <div class="row h-100">
                <!-- Sidebar -->
                <div class="col-md-4 col-lg-3 calls-sidebar">
                    <div class="sidebar-header">
                        <h4 class="mb-0">
                            <i class="fas fa-video me-2"></i>
                            Calls
                        </h4>
                        <div class="header-actions">
                            <button class="btn-icon" data-bs-toggle="modal" data-bs-target="#newCallModal" title="New Call">
                                <i class="fas fa-phone-plus"></i>
                            </button>
                            <button class="btn-icon" data-bs-toggle="dropdown" title="More">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user-friends me-2"></i>My Connections
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Search Box -->
                    <div class="search-box">
                        <div class="input-group">
                            <span class="input-group-text border-0">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control border-0" placeholder="Search calls..." id="searchCalls">
                        </div>
                    </div>

                    <!-- Quick Filters -->
                    <div class="quick-filters">
                        <button class="filter-chip active" data-filter="all">
                            All
                        </button>
                        <button class="filter-chip" data-filter="video">
                            <i class="fas fa-video me-1"></i>Video
                        </button>
                        <button class="filter-chip" data-filter="audio">
                            <i class="fas fa-phone me-1"></i>Audio
                        </button>
                        <button class="filter-chip" data-filter="missed">
                            <i class="fas fa-phone-slash me-1"></i>Missed
                        </button>
                    </div>

                    <!-- Calls List -->
                    <div class="calls-list">
                        @forelse($calls ?? [] as $call)
                                                @php
                                                    $otherUser = $call->initiated_by === auth()->id()
                                                        ? $call->recipient
                                                        : $call->initiator;
                                                    $avatar = !empty($otherUser->avatar_url)
                                                        ? (filter_var($otherUser->avatar_url, FILTER_VALIDATE_URL) ? $otherUser->avatar_url : asset('storage/' . $otherUser->avatar_url))
                                                        : asset('images/default-avatar.png');
                                                    $isOutgoing = $call->initiated_by === auth()->id();
                                                    $isMissed = $call->call_status === 'missed';
                                                @endphp

                                                <div class="call-item {{ $isMissed ? 'missed' : '' }}" data-call-id="{{ $call->call_id }}">
                                                    <div class="call-avatar-wrapper">
                                                        <img src="{{ 
                                !empty($otherUser->avatar_url)
                                    ? (filter_var($otherUser->avatar_url, FILTER_VALIDATE_URL)
                                        ? $otherUser->avatar_url
                                        : asset('storage/' . $otherUser->avatar_url))
                                    : asset('images/default-avatar.png') 
                            }}" alt="{{ $otherUser->first_name }}" class="call-avatar">
                                                        <span class="call-type-icon {{ $call->call_type }}">
                                                            <i class="fas fa-{{ $call->call_type === 'video' ? 'video' : 'phone' }}"></i>
                                                        </span>
                                                    </div>

                                                    <div class="call-info">
                                                        <div class="call-name">
                                                            {{ $otherUser->first_name }} {{ $otherUser->last_name }}
                                                            @if($isMissed)
                                                                <span class="missed-badge">Missed</span>
                                                            @endif
                                                        </div>
                                                        <div class="call-meta">
                                                            <i
                                                                class="fas fa-arrow-{{ $isOutgoing ? 'right' : 'left' }} me-1 {{ $isOutgoing ? 'text-success' : 'text-info' }}"></i>
                                                            <span>{{ $call->created_at->diffForHumans() }}</span>
                                                            @if($call->duration > 0)
                                                                <span class="mx-1">•</span>
                                                                <span>{{ gmdate('i:s', $call->duration) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="call-actions">
                                                        <button class="btn-action btn-call" onclick="startCall({{ $otherUser->user_id }}, 'video')"
                                                            title="Video Call">
                                                            <i class="fas fa-video"></i>
                                                        </button>
                                                        <button class="btn-action btn-audio" onclick="startCall({{ $otherUser->user_id }}, 'audio')"
                                                            title="Audio Call">
                                                            <i class="fas fa-phone"></i>
                                                        </button>
                                                    </div>
                                                </div>
                        @empty
                            <div class="empty-calls">
                                <i class="fas fa-video fa-3x mb-3"></i>
                                <p class="mb-3">No calls yet</p>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newCallModal">
                                    <i class="fas fa-phone-plus me-2"></i>Make a Call
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-md-8 col-lg-9 calls-content">
                    <div class="content-wrapper">
                        <div class="welcome-state">
                            <div class="welcome-content">
                                <div class="welcome-icon">
                                    <i class="fas fa-video"></i>
                                </div>
                                <h3 class="mt-4 mb-2">Select a call to view details</h3>
                                <p class="text-muted mb-4">Or start a new call with your connections</p>

                                <!-- Quick Actions -->
                                <div class="quick-actions-grid">
                                    <div class="quick-action-card" onclick="window.location='#'">
                                        <div class="action-icon">
                                            <i class="fas fa-user-friends"></i>
                                        </div>
                                        <h6>My Connections</h6>
                                        <p class="text-muted small">{{ $friendsCount ?? 0 }} Friends</p>
                                    </div>

                                    <div class="quick-action-card" data-bs-toggle="modal" data-bs-target="#newCallModal">
                                        <div class="action-icon bg-success">
                                            <i class="fas fa-phone-plus"></i>
                                        </div>
                                        <h6>New Call</h6>
                                        <p class="text-muted small">Start calling</p>
                                    </div>

                                    <div class="quick-action-card">
                                        <div class="action-icon bg-info">
                                            <i class="fas fa-history"></i>
                                        </div>
                                        <h6>Call History</h6>
                                        <p class="text-muted small">{{ $totalCalls ?? 0 }} Total</p>
                                    </div>

                                    <div class="quick-action-card">
                                        <div class="action-icon bg-warning">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        <h6>Settings</h6>
                                        <p class="text-muted small">Configure</p>
                                    </div>
                                </div>

                                <!-- Stats Overview -->
                                <div class="stats-overview mt-5">
                                    <div class="stat-item">
                                        <div class="stat-value">{{ $totalCalls ?? 0 }}</div>
                                        <div class="stat-label">Total Calls</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value">{{ $completedCalls ?? 0 }}</div>
                                        <div class="stat-label">Completed</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value">{{ $missedCalls ?? 0 }}</div>
                                        <div class="stat-label">Missed</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value">{{ $totalDuration ?? '0h' }}</div>
                                        <div class="stat-label">Total Time</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Call Modal -->
    <div class="modal fade" id="newCallModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <i class="fas fa-phone-plus me-2"></i>
                        New Call
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <div class="search-friends">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" placeholder="Search connections..." id="searchFriends">
                        </div>
                    </div>

                    <div class="friends-call-list" id="friendsList">
                        <div class="text-center py-4">
                            <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No connections yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .video-calls-messenger {
            height: calc(100vh - 80px);
            background: #f0f2f5;
        }

        .video-calls-messenger .row {
            height: 100%;
            margin: 0;
        }

        .calls-sidebar {
            background: white;
            border-right: 1px solid #e4e6eb;
            padding: 0;
            height: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .calls-content {
            background: #f0f2f5;
            padding: 0;
            height: 100%;
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 1rem;
            border-bottom: 1px solid #e4e6eb;
        }

        .sidebar-header h4 {
            font-weight: 700;
            color: #050505;
        }

        .header-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #f0f2f5;
            color: #65676b;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-icon:hover {
            background: #e4e6eb;
        }

        .search-box {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e4e6eb;
        }

        .search-box .input-group {
            background: #f0f2f5;
            border-radius: 20px;
            overflow: hidden;
        }

        .search-box .input-group-text {
            background: transparent;
            color: #65676b;
        }

        .search-box .form-control {
            background: transparent;
            color: #050505;
        }

        .search-box .form-control:focus {
            box-shadow: none;
        }

        .quick-filters {
            display: flex;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e4e6eb;
            overflow-x: auto;
        }

        .filter-chip {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            border: none;
            background: #f0f2f5;
            color: #65676b;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .filter-chip:hover {
            background: #e4e6eb;
        }

        .filter-chip.active {
            background: #e7f3ff;
            color: #0084ff;
        }

        .calls-list {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem 0;
        }

        .calls-list::-webkit-scrollbar {
            width: 6px;
        }

        .calls-list::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .call-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .call-item:hover {
            background: #f2f3f5;
        }

        .call-item.missed {
            background: #fff5f5;
        }

        .call-avatar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .call-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
        }

        .call-type-icon {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: white;
            border: 2px solid white;
        }

        .call-type-icon.video {
            background: #0084ff;
        }

        .call-type-icon.audio {
            background: #00c851;
        }

        .call-info {
            flex: 1;
            min-width: 0;
        }

        .call-name {
            font-weight: 600;
            color: #050505;
            font-size: 15px;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .missed-badge {
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            background: #ff4458;
            color: white;
            font-weight: 600;
        }

        .call-meta {
            font-size: 13px;
            color: #65676b;
        }

        .call-actions {
            display: none;
            gap: 0.5rem;
        }

        .call-item:hover .call-actions {
            display: flex;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-call {
            background: #e7f3ff;
            color: #0084ff;
        }

        .btn-call:hover {
            background: #0084ff;
            color: white;
        }

        .btn-audio {
            background: #e8f8f1;
            color: #00c851;
        }

        .btn-audio:hover {
            background: #00c851;
            color: white;
        }

        .empty-calls {
            text-align: center;
            padding: 3rem 1rem;
            color: #65676b;
        }

        .content-wrapper {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .welcome-state {
            text-align: center;
            max-width: 800px;
            width: 100%;
        }

        .welcome-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 48px;
            color: white;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        }

        .welcome-content h3 {
            font-weight: 700;
            color: #050505;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .quick-action-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .quick-action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .action-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 24px;
            color: white;
        }

        .action-icon.bg-success {
            background: linear-gradient(135deg, #00c851 0%, #00a844 100%);
        }

        .action-icon.bg-info {
            background: linear-gradient(135deg, #33b5e5 0%, #0099cc 100%);
        }

        .action-icon.bg-warning {
            background: linear-gradient(135deg, #ffbb33 0%, #ff8800 100%);
        }

        .quick-action-card h6 {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #050505;
        }

        .stats-overview {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            padding: 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #0084ff;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 14px;
            color: #65676b;
        }

        .search-friends {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-friends i {
            position: absolute;
            left: 1rem;
            color: #65676b;
        }

        .search-friends .form-control {
            padding-left: 2.5rem;
            border-radius: 20px;
            border: 1px solid #e4e6eb;
            background: #f0f2f5;
        }

        .friends-call-list {
            max-height: 400px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .quick-actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-overview {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('searchCalls')?.addEventListener('input', function (e) {
            const query = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.call-item');
            items.forEach(item => {
                const name = item.querySelector('.call-name').textContent.toLowerCase();
                item.style.display = name.includes(query) ? 'flex' : 'none';
            });
        });

        document.querySelectorAll('.filter-chip').forEach(chip => {
            chip.addEventListener('click', function () {
                document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                const filter = this.dataset.filter;
                const items = document.querySelectorAll('.call-item');
                items.forEach(item => {
                    if (filter === 'all') {
                        item.style.display = 'flex';
                    } else if (filter === 'missed') {
                        item.style.display = item.classList.contains('missed') ? 'flex' : 'none';
                    } else {
                        const hasType = item.querySelector(`.call-type-icon.${filter}`);
                        item.style.display = hasType ? 'flex' : 'none';
                    }
                });
            });
        });

        function startCall(userId, type) {
            window.location.href = `/conversations/user/${userId}/call?type=${type}`;
        }
    </script>
@endpush