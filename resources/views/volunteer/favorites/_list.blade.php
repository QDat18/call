{{-- resources/views/volunteer/favorites/_list.blade.php --}}
@if($favorites->count() > 0)
    <!-- Thanh chọn & xóa hàng loạt -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl p-6 mb-8">
        <form id="bulkForm" action="{{ route('volunteer.favorites.bulk-destroy') ?? '#' }}" method="POST">
            @csrf
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <input type="checkbox" id="selectAll" class="w-5 h-5 text-purple-600 rounded">
                    <label for="selectAll" class="font-medium">Chọn tất cả</label>
                    <span class="text-gray-500">(<span id="selectedCount">0</span> được chọn)</span>
                </div>
                <button type="submit" id="bulkDelete" disabled
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-medium shadow transition disabled:opacity-50">
                    <i class="fas fa-trash mr-2"></i> Xóa đã chọn
                </button>
            </div>
        </form>
    </div>

    <!-- Grid card -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @foreach($favorites as $favorite)
            @php $opp = $favorite->opportunity; @endphp
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 border border-purple-100 dark:border-purple-900">
                <!-- Ảnh + nút yêu thích -->
                <div class="relative h-56">
                    @if($opp->image)
                        <img src="{{ asset('storage/' . $opp->image) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-hands-helping text-white text-6xl opacity-30"></i>
                        </div>
                    @endif

                    <!-- Nút bỏ yêu thích (AJAX) -->
                    <button type="button" data-id="{{ $opp->opportunity_id }}"
                            class="favorite-btn absolute top-4 right-4 w-12 h-12 bg-white/90 dark:bg-slate-900/90 rounded-full shadow-xl flex items-center justify-center text-red-500 hover:scale-110 transition">
                        <i class="fas fa-heart text-xl"></i>
                    </button>

                    <!-- Checkbox chọn -->
                    <div class="absolute top-4 left-4">
                        <input type="checkbox" name="favorite_ids[]" value="{{ $favorite->favorite_id }}"
                               class="bulk-checkbox w-5 h-5 text-purple-600 rounded">
                    </div>
                </div>

                <!-- Nội dung -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-3 line-clamp-2">
                        {{ $opp->title }}
                    </h3>

                    <div class="flex items-center gap-2 text-purple-600 dark:text-purple-400 text-sm mb-4">
                        <i class="fas fa-building"></i>
                        <span>{{ $opp->organization->organization_name }}</span>
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-5">
                        {{ Str::limit(strip_tags($opp->description), 110) }}
                    </p>

                    <!-- Ghi chú -->
                    <form action="{{ route('volunteer.favorites.notes', $favorite->favorite_id) }}" method="POST" class="mb-5">
                        @csrf @method('PUT')
                        <textarea name="notes" rows="2" placeholder="Ghi chú của bạn..."
                                  class="w-full px-4 py-3 text-sm border border-purple-200 dark:border-purple-700 rounded-xl focus:ring-4 focus:ring-purple-100 dark:bg-slate-700 resize-none">{{ $favorite->notes }}</textarea>
                        <div class="text-right mt-2">
                            <button type="submit" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                <i class="fas fa-save mr-1"></i> Lưu ghi chú
                            </button>
                        </div>
                    </form>

                    <!-- Nút hành động -->
                    <div class="flex justify-between items-center pt-4 border-t border-purple-100 dark:border-purple-800">
                        <a href="{{ route('opportunities.show', $opp->opportunity_id) }}"
                           class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-xl hover:shadow-lg transition">
                            Xem chi tiết
                        </a>

                        <form action="{{ route('volunteer.favorites.destroy', $favorite->favorite_id) }}" method="POST"
                              onsubmit="return confirm('Xóa khỏi yêu thích?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xl">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="mt-12 flex justify-center">
        {{ $favorites->appends(request()->query())->links('pagination::tailwind') }}
    </div>

@else
    <!-- Empty State đẹp lung linh -->
    <div class="text-center py-24 bg-white dark:bg-slate-800 rounded-3xl shadow-2xl">
        <i class="fas fa-heart-broken text-9xl text-purple-200 dark:text-purple-800 mb-8"></i>
        <h2 class="text-4xl font-bold text-gray-700 dark:text-gray-300 mb-4">
            Chưa có cơ hội nào được yêu thích
        </h2>
        <p class="text-xl text-gray-500 dark:text-gray-400 mb-10">
            Hãy khám phá và lưu lại những cơ hội bạn thấy thú vị!
        </p>
        <a href="{{ route('opportunities.index') }}" 
           class="inline-flex items-center gap-4 px-10 py-5 bg-gradient-to-r from-purple-600 to-pink-600 text-white text-xl font-bold rounded-2xl hover:shadow-2xl transition transform hover:scale-105">
            <i class="fas fa-search"></i> Tìm kiếm ngay
        </a>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.bulk-checkbox');
    const bulkBtn = document.getElementById('bulkDelete');
    const countEl = document.getElementById('selectedCount');

    selectAll?.addEventListener('change', () => {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
        updateCount();
    });
    checkboxes.forEach(cb => cb.addEventListener('change', updateCount));

    function updateCount() {
        const checked = document.querySelectorAll('.bulk-checkbox:checked').length;
        countEl.textContent = checked;
        bulkBtn.disabled = checked === 0;
    }

    // AJAX bỏ yêu thích
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            fetch("{{ route('volunteer.favorites.toggle') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ opportunity_id: this.dataset.id })
            })
            .then(r => r.json())
            .then(data => {
                if (data.action === 'removed') {
                    this.closest('.bg-white, .dark\\:bg-slate-800').style.opacity = '0';
                    setTimeout(() => this.closest('.bg-white, .dark\\:bg-slate-800').parentElement.remove(), 400);
                }
            });
        });
    });
});
</script>