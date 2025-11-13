@extends('layouts.app')

@section('title', 'Call Ended')

@section('content')
<div class="call-ended-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="call-ended-card">
                    <!-- Header -->
                    <div class="card-header text-center">
                        <div class="call-ended-icon">
                            @if($call->call_status === 'ended')
                                <i class="fas fa-phone-slash"></i>
                            @elseif($call->call_status === 'missed')
                                <i class="fas fa-phone-slash text-warning"></i>
                            @elseif($call->call_status === 'declined')
                                <i class="fas fa-times-circle text-danger"></i>
                            @else
                                <i class="fas fa-phone"></i>
                            @endif
                        </div>
                        <h3 class="mt-3 mb-1">
                            @if($call->call_status === 'ended')
                                Call Ended
                            @elseif($call->call_status === 'missed')
                                Call Missed
                            @elseif($call->call_status === 'declined')
                                Call Declined
                            @else
                                Call Completed
                            @endif
                        </h3>
                        <p class="text-muted mb-0">
                            {{ $call->call_type === 'video' ? 'Video' : 'Audio' }} call with 
                            <strong>{{ $otherUser->first_name }} {{ $otherUser->last_name }}</strong>
                        </p>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Participant Info -->
                        <div class="participant-section text-center mb-4">
    <img 
        src="{{ $otherUser->avatar_url ?? asset('images/default-avatar.png') }}" 
        alt="{{ $otherUser->first_name ?? 'User' }}"
        class="participant-avatar">
    <h5 class="mt-3 mb-1">{{ $otherUser->first_name ?? 'Unknown' }} {{ $otherUser->last_name ?? 'User' }}</h5>
    <p class="text-muted mb-0">
        @if(isset($otherUser->user_type))
            @if($otherUser->user_type === 'Organization')
                <i class="fas fa-building me-1"></i>Organization
            @elseif($otherUser->user_type === 'Volunteer')
                <i class="fas fa-user me-1"></i>Volunteer
            @endif
        @endif
    </p>
</div>

                        <!-- Call Stats -->
                        <div class="call-stats">
                            <div class="row text-center">
                                <!-- Duration -->
                                <div class="col-4">
                                    <div class="stat-item">
                                        <i class="fas fa-stopwatch fa-2x text-primary mb-2"></i>
                                        <h4 class="mb-0">
                                            @if($call->duration > 0)
                                                {{ gmdate('H:i:s', $call->duration) }}
                                            @else
                                                00:00:00
                                            @endif
                                        </h4>
                                        <small class="text-muted">Duration</small>
                                    </div>
                                </div>

                                <!-- Call Type -->
                                <div class="col-4">
                                    <div class="stat-item">
                                        <i class="fas fa-{{ $call->call_type === 'video' ? 'video' : 'phone' }} fa-2x text-success mb-2"></i>
                                        <h4 class="mb-0 text-capitalize">{{ $call->call_type }}</h4>
                                        <small class="text-muted">Call Type</small>
                                    </div>
                                </div>

                                <!-- Time -->
                                <div class="col-4">
                                    <div class="stat-item">
                                        <i class="far fa-clock fa-2x text-info mb-2"></i>
                                        <h4 class="mb-0">{{ $call->created_at->format('h:i A') }}</h4>
                                        <small class="text-muted">Started At</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Call Details -->
                        <div class="call-details mt-4">
                            <h6 class="mb-3">
                                <i class="fas fa-info-circle me-2"></i>Call Details
                            </h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Call ID</span>
                                    <strong>#{{ $call->call_id }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Status</span>
                                    @php
                                        $statusConfig = [
                                            'ended' => ['class' => 'success', 'text' => 'Completed'],
                                            'missed' => ['class' => 'warning', 'text' => 'Missed'],
                                            'declined' => ['class' => 'danger', 'text' => 'Declined'],
                                        ];
                                        $config = $statusConfig[$call->call_status] ?? ['class' => 'secondary', 'text' => $call->call_status];
                                    @endphp
                                    <span class="badge bg-{{ $config['class'] }}">{{ $config['text'] }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Date</span>
                                    <strong>{{ $call->created_at->format('M d, Y') }}</strong>
                                </li>
                                @if($call->started_at)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Connected At</span>
                                    <strong>{{ \Carbon\Carbon::parse($call->started_at)->format('h:i A') }}</strong>
                                </li>
                                @endif
                                @if($call->ended_at)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Ended At</span>
                                    <strong>{{ \Carbon\Carbon::parse($call->ended_at)->format('h:i A') }}</strong>
                                </li>
                                @endif
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">Direction</span>
                                    <strong>
                                        @if($call->initiated_by === auth()->id())
                                            <i class="fas fa-arrow-right text-success me-1"></i>Outgoing
                                        @else
                                            <i class="fas fa-arrow-left text-info me-1"></i>Incoming
                                        @endif
                                    </strong>
                                </li>
                            </ul>
                        </div>

                        <!-- Feedback Section (Optional) -->
                        @if($call->call_status === 'ended' && $call->duration > 0)
                        <div class="feedback-section mt-4">
                            <h6 class="mb-3">
                                <i class="fas fa-star me-2"></i>Rate This Call
                            </h6>
                            <form action="{{ route('video-calls.feedback', $call->call_id) }}" method="POST">
                                @csrf
                                <div class="rating-stars text-center mb-3">
                                    <input type="radio" name="rating" value="5" id="star5" class="d-none">
                                    <label for="star5" class="star"><i class="far fa-star"></i></label>
                                    
                                    <input type="radio" name="rating" value="4" id="star4" class="d-none">
                                    <label for="star4" class="star"><i class="far fa-star"></i></label>
                                    
                                    <input type="radio" name="rating" value="3" id="star3" class="d-none">
                                    <label for="star3" class="star"><i class="far fa-star"></i></label>
                                    
                                    <input type="radio" name="rating" value="2" id="star2" class="d-none">
                                    <label for="star2" class="star"><i class="far fa-star"></i></label>
                                    
                                    <input type="radio" name="rating" value="1" id="star1" class="d-none">
                                    <label for="star1" class="star"><i class="far fa-star"></i></label>
                                </div>
                                <div class="mb-3">
                                    <textarea 
                                        name="feedback" 
                                        class="form-control" 
                                        rows="3" 
                                        placeholder="Share your experience... (Optional)"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Feedback
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>

                    <!-- Footer Actions -->
                    <div class="card-footer">
                        <div class="row g-2">
                            <!-- Call Again -->
                            <div class="col-md-4">
                                <a 
                                    href="{{ route('conversations.show', $call->conversation_id) }}" 
                                    class="btn btn-primary w-100">
                                    <i class="fas fa-phone me-2"></i>Call Again
                                </a>
                            </div>

                            <!-- Send Message -->
                            <div class="col-md-4">
                                <a 
                                    href="{{ route('conversations.show', $call->conversation_id) }}" 
                                    class="btn btn-outline-primary w-100">
                                    <i class="fas fa-comment me-2"></i>Message
                                </a>
                            </div>

                            <!-- Call History -->
                            <div class="col-md-4">
                                <a 
                                    href="{{ route('video-calls.index') }}" 
                                    class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-history me-2"></i>History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Actions -->
                <div class="text-center mt-4">
                    <a href="{{ route('dashboard') }}" class="text-muted">
                        <i class="fas fa-home me-1"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .call-ended-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 0;
    }

    .call-ended-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .call-ended-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border: none;
    }

    .call-ended-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 36px;
    }

    .call-ended-card .card-body {
        padding: 2rem;
    }

    .participant-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #667eea;
    }

    .call-stats {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
    }

    .stat-item {
        padding: 1rem;
    }

    .call-details {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
    }

    .feedback-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
    }

    .rating-stars {
        display: flex;
        justify-content: center;
        gap: 10px;
        direction: rtl;
    }

    .rating-stars .star {
        font-size: 32px;
        color: #ddd;
        cursor: pointer;
        transition: all 0.2s;
    }

    .rating-stars .star:hover,
    .rating-stars .star:hover ~ .star,
    .rating-stars input:checked ~ .star {
        color: #ffc107;
    }

    .rating-stars .star:hover i,
    .rating-stars input:checked ~ .star i {
        transform: scale(1.2);
    }

    .rating-stars .star i {
        transition: transform 0.2s;
    }

    .call-ended-card .card-footer {
        background: white;
        padding: 1.5rem;
        border-top: 1px solid #e9ecef;
    }

    @media (max-width: 768px) {
        .call-ended-page {
            padding: 1rem;
        }

        .call-ended-card .card-header,
        .call-ended-card .card-body,
        .call-ended-card .card-footer {
            padding: 1.5rem;
        }

        .stat-item {
            padding: 0.75rem;
        }

        .stat-item i {
            font-size: 1.5rem !important;
        }

        .stat-item h4 {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Star rating interaction
    document.querySelectorAll('.rating-stars .star').forEach(star => {
        star.addEventListener('click', function() {
            const input = this.previousElementSibling;
            if (input) {
                input.checked = true;
            }
        });
    });

    // Auto-redirect after 30 seconds (optional)
    let countdown = 30;
    const redirectTimer = setInterval(() => {
        countdown--;
        if (countdown === 0) {
            window.location.href = '{{ route('video-calls.index') }}';
            clearInterval(redirectTimer);
        }
    }, 1000);

    // Clear timer if user interacts
    document.addEventListener('click', () => {
        clearInterval(redirectTimer);
    });
</script>
@endpush