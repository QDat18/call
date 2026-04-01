@extends('layouts.app')
@section('title', $campaign->title)

@section('content')
    <article class="min-h-screen bg-gray-50">
        {{-- Hero Banner --}}
        <section class="relative h-[500px] overflow-hidden">
            <img src="{{ asset('storage/' . $campaign->banner_image_url) }}" alt="{{ $campaign->title }}"
                class="w-full h-full object-cover" loading="eager">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent"></div>

            {{-- Hero Content --}}
            <div class="absolute inset-0 flex items-end">
                <div class="max-w-7xl mx-auto px-6 pb-16 w-full">
                    <div class="max-w-4xl">
                        {{-- Status Badge --}}
                        @if($campaign->end_date > now() && $campaign->status == 'Active')
                            <span
                                class="inline-flex items-center gap-2 bg-emerald-500/90 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 shadow-lg">
                                <span class="relative flex h-3 w-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                                </span>
                                Đang kêu gọi quyên góp
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-2 bg-gray-500/90 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-4 shadow-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                Đã kết thúc
                            </span>
                        @endif

                        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight drop-shadow-lg">
                            {{ $campaign->title }}
                        </h1>

                        <div class="flex flex-wrap gap-6 text-white/90 text-sm">
                            <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-3 py-1.5 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ $campaign->adminUser->first_name ?? 'Ban tổ chức' }}</span>
                            </div>
                            <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-3 py-1.5 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <time datetime="{{ $campaign->end_date->toIso8601String() }}">
                                    Hạn: {{ $campaign->end_date->format('d/m/Y') }}
                                </time>
                            </div>
                            @php
                                $donors_count = $campaign->donations()->where('status', 'Success')->count();
                            @endphp
                            <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-3 py-1.5 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>{{ $donors_count }} người ủng hộ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Progress Section --}}
        @php
            $progress = ($campaign->current_amount > 0 && $campaign->target_amount > 0)
                ? min(($campaign->current_amount / $campaign->target_amount) * 100, 100) : 0;
            $days_left = max(0, now()->diffInDays($campaign->end_date, false));
        @endphp

        <section class="bg-white border-b sticky top-0 z-10 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-600 mb-1">Đã quyên góp</p>
                        <p class="text-3xl font-bold text-blue-600">
                            {{ number_format($campaign->current_amount / 1000000, 1) }}M
                        </p>
                        <p class="text-xs text-gray-500">{{ number_format($campaign->current_amount, 0, ',', '.') }} VNĐ</p>
                    </div>

                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-600 mb-1">Mục tiêu</p>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ number_format($campaign->target_amount / 1000000, 2) }}M
                        </p>
                        <p class="text-xs text-gray-500">{{ number_format($campaign->target_amount, 0, ',', '.') }} VNĐ</p>
                    </div>

                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-600 mb-1">Lượt đóng góp</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $donors_count }}</p>
                        <p class="text-xs text-gray-500">Nhà hảo tâm</p>
                    </div>

                    <div class="text-center md:text-left">
                        <p class="text-sm text-gray-600 mb-1">Thời gian còn lại</p>
                        <p class="text-3xl font-bold text-orange-600">{{ ceil($days_left) }}</p>
                        <p class="text-xs text-gray-500">Ngày</p>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-600">Tiến độ</span>
                        <span class="text-2xl font-bold text-gray-900">{{ number_format($progress, 1) }}%</span>
                    </div>
                    <div class="relative h-4 bg-gray-200 rounded-full overflow-hidden">
                        <div class="absolute h-full bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-1000 ease-out rounded-full"
                            style="width: {{ $progress }}%">
                            <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                        </div>
                    </div>
                    @if($progress >= 100)
                        <p class="text-center text-sm font-semibold text-green-600 mt-3">
                            ✓ Đã đạt mục tiêu! Cảm ơn sự ủng hộ của mọi người
                        </p>
                    @endif
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Left Content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Story --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-1 h-8 bg-blue-600 rounded-full mr-4"></span>
                            Câu chuyện
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($campaign->description)) !!}
                        </div>
                    </div>

                    {{-- Supporters --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <span class="w-1 h-8 bg-purple-600 rounded-full mr-4"></span>
                            Những người đồng hành ({{ $donors_count }})
                        </h2>

                        <div class="space-y-4">
                            @forelse($recentDonations as $donation)
                                <div
                                    class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                    <img src="{{ !empty($donation->user->avatar_url) ? (Str::startsWith($donation->user->avatar_url, ['http']) ? $donation->user->avatar_url : asset('storage/' . $donation->user->avatar_url)) : 'https://ui-avatars.com/api/?name=' . urlencode($donation->user->first_name) . '&background=6366f1&color=fff' }}"
                                        alt="Avatar" class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm"
                                        loading="lazy">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-baseline justify-between gap-2 mb-1">
                                            <h3 class="font-semibold text-gray-900 truncate">
                                                {{ $donation->user->first_name }} {{ $donation->user->last_name }}
                                            </h3>
                                            <span class="font-bold text-blue-600 text-lg whitespace-nowrap">
                                                {{ number_format($donation->amount, 0, ',', '.') }}đ
                                            </span>
                                        </div>
                                        @if($donation->message)
                                            <p
                                                class="text-gray-600 text-sm mb-2 italic bg-white p-3 rounded-lg border-l-4 border-blue-300">
                                                "{{ $donation->message }}"
                                            </p>
                                        @endif
                                        <time class="text-xs text-gray-400"
                                            datetime="{{ $donation->created_at->toIso8601String() }}">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $donation->created_at->diffForHumans() }}
                                        </time>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-16 bg-gray-50 rounded-xl">
                                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <p class="text-gray-500 font-semibold text-lg mb-2">Hãy là người đầu tiên</p>
                                    <p class="text-gray-400 text-sm">Chia sẻ yêu thương và góp phần tạo nên sự khác biệt</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Right Sidebar --}}
                <aside class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        {{-- Donation Form --}}
                        @if($campaign->end_date > now() && $campaign->status == 'Active')
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                                <div class="bg-gradient-to-r from-[#005ba3] to-[#00467a] p-6 text-white">
                                    <h2 class="text-2xl font-bold mb-2 flex items-center">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Quyên góp qua VNPay
                                    </h2>
                                    <p class="text-blue-100 text-sm">Hỗ trợ thẻ ATM nội địa & Quốc tế</p>
                                </div>

                                {{-- Action trỏ về route createPayment (Đã được update logic MoMo trong Controller) --}}
                                <form action="{{ route('donation.createPayment') }}" method="POST" class="p-6 space-y-5">
                                    @csrf
                                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

                                    @if(session('error'))
                                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <div>
                                        <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Số tiền quyên góp (VNĐ)
                                        </label>
                                        <div class="relative">
                                            <input type="number" name="amount" id="amount" required min="5000" step="1000"
                                                value="10000" placeholder="Nhập số tiền tùy ý (tối thiểu 5.000đ)"
                                                class="w-full px-4 py-3 pr-16 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-[#005ba3] focus:border-transparent transition text-lg font-semibold text-[#005ba3]">
                                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">
                                                VNĐ
                                            </span>
                                        </div>
                                        @error('amount')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Quick amount buttons --}}
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach([50000, 100000, 200000, 500000, 1000000, 2000000] as $amount)
                                            <button type="button" onclick="document.getElementById('amount').value='{{ $amount }}'"
                                                class="px-3 py-2.5 bg-gray-50 hover:bg-pink-50 border-2 border-gray-200 hover:border-pink-400 rounded-lg text-sm font-bold text-gray-700 hover:text-[#d82d8b] transition-all transform hover:scale-105">
                                                {{ $amount >= 1000000 ? number_format($amount / 1000000, 0) . 'M' : number_format($amount / 1000, 0) . 'K' }}
                                            </button>
                                        @endforeach
                                    </div>

                                    <div>
                                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Lời nhắn (Tùy chọn)
                                        </label>
                                        <textarea name="message" id="message" rows="3"
                                            placeholder="Chia sẻ động viên của bạn..."
                                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-[#d82d8b] focus:border-transparent transition resize-none"></textarea>
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-[#005ba3] hover:bg-[#00467a] text-white font-bold py-4 px-6 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center text-lg">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Thanh toán qua VNPay
                                    </button>

                                    <div class="flex items-center justify-center text-xs text-gray-500 gap-2">
                                        <i class="fas fa-shield-alt text-green-600"></i>
                                        <span>Cổng thanh toán VNPay Sandbox</span>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="bg-gray-50 border-2 border-gray-200 rounded-2xl p-8 text-center">
                                <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <h3 class="font-bold text-gray-900 text-lg mb-2">Chiến dịch đã kết thúc</h3>
                                <p class="text-sm text-gray-600 mb-4">Cảm ơn mọi người đã quan tâm và ủng hộ</p>
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <p class="text-xs text-gray-500 mb-1">Tổng quyên góp đạt được</p>
                                    <p class="text-2xl font-bold text-blue-600">
                                        {{ number_format($campaign->current_amount, 0, ',', '.') }}đ
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- Share Section --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Chia sẻ chiến dịch
                            </h3>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition-all transform hover:scale-105 shadow-md">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                    <span class="font-semibold">Facebook</span>
                                </a>
                                <button onclick="copyLink()"
                                    class="flex items-center justify-center gap-2 bg-gray-700 hover:bg-gray-800 text-white py-3 rounded-xl transition-all transform hover:scale-105 shadow-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-semibold">Sao chép</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </article>

    <script>
        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Đã sao chép link!');
            }).catch(() => {
                alert('Không thể sao chép. Vui lòng thử lại.');
            });
        }
    </script>
@endsection