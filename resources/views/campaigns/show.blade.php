@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
<article class="min-h-screen bg-white">
    {{-- Hero Section --}}
    <header class="relative h-[70vh] overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('storage/' . $campaign->banner_image_url) }}" 
                 alt="{{ $campaign->title }}"
                 class="w-full h-full object-cover"
                 loading="eager">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
        </div>
        
        <div class="relative h-full max-w-7xl mx-auto px-6 flex flex-col justify-end pb-16">
            <div class="max-w-3xl">
                @if($campaign->end_date > now() && $campaign->status == 'Active')
                    <span class="inline-flex items-center gap-2 bg-emerald-500 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                        </span>
                        Đang kêu gọi
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 bg-gray-500 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        Đã kết thúc
                    </span>
                @endif
                
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                    {{ $campaign->title }}
                </h1>
                
                <div class="flex flex-wrap gap-6 text-white/90 text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>{{ $campaign->adminUser->first_name ?? 'Tổ chức từ thiện' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <time datetime="{{ $campaign->end_date->toIso8601String() }}">
                            Hạn chót: {{ $campaign->end_date->format('d/m/Y') }}
                        </time>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Progress Stats Section --}}
    @php
        $progress = ($campaign->current_amount > 0 && $campaign->target_amount > 0) 
                    ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) : 0;
        $donors_count = $campaign->donations()->where('status', 'Success')->count();
        $days_left = max(0, now()->diffInDays($campaign->end_date, false));
    @endphp
    
    <section class="bg-gradient-to-b from-gray-50 to-white py-12 border-b">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-gray-500 text-sm font-medium mb-2">Đã quyên góp</div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">
                        {{ number_format($campaign->current_amount / 1000000, 1) }}M
                    </div>
                    <div class="text-xs text-gray-400">{{ number_format($campaign->current_amount, 0, ',', '.') }} VNĐ</div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-gray-500 text-sm font-medium mb-2">Mục tiêu</div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">
                        {{ number_format($campaign->target_amount / 1000000, 1) }}M
                    </div>
                    <div class="text-xs text-gray-400">{{ number_format($campaign->target_amount, 0, ',', '.') }} VNĐ</div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-gray-500 text-sm font-medium mb-2">Lượt đóng góp</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $donors_count }}</div>
                    <div class="text-xs text-gray-400">Nhà hảo tâm</div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-gray-500 text-sm font-medium mb-2">Thời gian còn lại</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $days_left }}</div>
                    <div class="text-xs text-gray-400">Ngày</div>
                </div>
            </div>
            
            {{-- Progress Bar --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm font-medium text-gray-600">Tiến độ</span>
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($progress, 1) }}%</span>
                </div>
                <div class="relative h-3 bg-gray-200 rounded-full overflow-hidden">
                    <div class="absolute h-full bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-700 ease-out rounded-full"
                         style="width: {{ $progress }}%">
                    </div>
                </div>
                @if($progress >= 100)
                    <div class="mt-4 text-center text-sm font-medium text-emerald-600">
                        ✓ Đã đạt được mục tiêu! Cảm ơn sự ủng hộ của cộng đồng
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Main Content Grid --}}
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            {{-- Left Content --}}
            <div class="lg:col-span-2 space-y-10">
                {{-- Story Section --}}
                <section class="prose prose-lg max-w-none">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Câu chuyện</h2>
                    <div class="text-gray-700 leading-relaxed space-y-4">
                        {!! nl2br(e($campaign->description)) !!}
                    </div>
                </section>

                {{-- Supporters Section --}}
                <section>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">
                        Những người đồng hành ({{ $donors_count }})
                    </h2>
                    
                    <div class="space-y-4">
                        @forelse($recentDonations->take(10) as $donation)
                            <div class="bg-white border border-gray-100 rounded-xl p-5 hover:border-gray-200 transition-colors">
                                <div class="flex items-start gap-4">
                                    <img src="{{ $donation->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($donation->user->first_name) . '&background=6366f1&color=fff' }}" 
                                         alt="Avatar"
                                         class="w-14 h-14 rounded-full object-cover"
                                         loading="lazy">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-baseline justify-between gap-2 mb-2">
                                            <h3 class="font-semibold text-gray-900">
                                                {{ $donation->user->first_name }} {{ $donation->user->last_name }}
                                            </h3>
                                            <span class="font-bold text-blue-600 text-lg whitespace-nowrap">
                                                {{ number_format($donation->amount, 0, ',', '.') }}đ
                                            </span>
                                        </div>
                                        @if($donation->message)
                                            <p class="text-gray-600 text-sm mb-2 italic">
                                                "{{ $donation->message }}"
                                            </p>
                                        @endif
                                        <time class="text-xs text-gray-400" datetime="{{ $donation->created_at->toIso8601String() }}">
                                            {{ $donation->created_at->diffForHumans() }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16 bg-gray-50 rounded-xl">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">Hãy là người đầu tiên chia sẻ yêu thương</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Right Sidebar - Donation Form --}}
            <aside class="lg:col-span-1">
                <div class="sticky top-6 space-y-6">
                    @if($campaign->end_date > now() && $campaign->status == 'Active')
                        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                            <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-6 text-white">
                                <h2 class="text-2xl font-bold mb-2">Chung tay quyên góp</h2>
                                <p class="text-blue-100 text-sm">Mỗi đóng góp đều có ý nghĩa</p>
                            </div>
                            
                            <form action="{{ route('donation.createPayment') }}" method="POST" class="p-6 space-y-5">
                                @csrf
                                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                                
                                @if(session('error'))
                                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                
                                <div>
                                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Số tiền quyên góp
                                    </label>
                                    <div class="relative">
                                        <input type="number" 
                                               name="amount" 
                                               id="amount" 
                                               required 
                                               min="10000" 
                                               step="10000"
                                               placeholder="Nhập số tiền"
                                               class="w-full px-4 py-3 pr-16 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-lg font-medium">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">
                                            VNĐ
                                        </span>
                                    </div>
                                    @error('amount')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-3 gap-2">
                                    @foreach([50000, 100000, 200000, 500000, 1000000, 2000000] as $amount)
                                        <button type="button" 
                                                onclick="document.getElementById('amount').value='{{ $amount }}'"
                                                class="px-3 py-2 bg-gray-50 hover:bg-blue-50 border border-gray-200 hover:border-blue-300 rounded-lg text-sm font-medium text-gray-700 hover:text-blue-600 transition-all">
                                            {{ $amount >= 1000000 ? number_format($amount/1000000, 0) . 'M' : number_format($amount/1000, 0) . 'K' }}
                                        </button>
                                    @endforeach
                                </div>
                                
                                <div>
                                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Lời nhắn
                                    </label>
                                    <textarea name="message" 
                                              id="message" 
                                              rows="3"
                                              placeholder="Chia sẻ động viên của bạn..."
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"></textarea>
                                </div>

                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                    Quyên góp ngay
                                </button>
                                
                                <p class="text-xs text-gray-500 text-center">
                                    Thanh toán an toàn qua VNPay
                                </p>
                            </form>
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-8 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <h3 class="font-bold text-gray-900 mb-2">Chiến dịch đã kết thúc</h3>
                            <p class="text-sm text-gray-600">Cảm ơn mọi người đã quan tâm và ủng hộ</p>
                        </div>
                    @endif

                    {{-- Share Section --}}
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Chia sẻ chiến dịch</h3>
                        <div class="flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-center transition">
                                <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <button onclick="navigator.share ? navigator.share({title: '{{ $campaign->title }}', url: '{{ request()->url() }}'}) : alert('Trình duyệt không hỗ trợ')"
                                    class="flex-1 bg-gray-700 hover:bg-gray-800 text-white py-2 rounded-lg transition">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</article>
@endsection 