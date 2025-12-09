{{-- resources/views/volunteer/favorites/_list.blade.php --}}
@if($favorites->count() > 0)
    
    {{-- Bulk Action Bar --}}
    <div class="bg-purple-50 rounded-xl p-4 mb-6 flex items-center justify-between border border-purple-100">
        <div class="flex items-center gap-3">
            <input type="checkbox" id="selectAll" class="w-5 h-5 text-purple-600 rounded border-gray-300 focus:ring-purple-500 cursor-pointer">
            <label for="selectAll" class="font-bold text-gray-700 cursor-pointer select-none">Chọn tất cả</label>
            <span class="text-gray-400">|</span>
            <span class="text-sm text-gray-600">Đã chọn: <span id="selectedCount" class="font-bold text-purple-600">0</span></span>
        </div>
        
        <form id="bulkForm" action="{{ route('volunteer.favorites.bulk-destroy') }}" method="POST">
            @csrf
            {{-- Input hidden nhận JSON ID từ JS --}}
            <input type="hidden" name="favorite_ids" id="bulkInputIds">
            
            <button type="button" id="bulkDeleteBtn" disabled
                class="px-4 py-2 bg-white text-gray-400 border border-gray-200 rounded-lg text-sm font-bold shadow-sm transition flex items-center gap-2 cursor-not-allowed
                       data-[active=true]:bg-rose-600 data-[active=true]:text-white data-[active=true]:border-rose-600 data-[active=true]:cursor-pointer data-[active=true]:shadow-rose-200">
                <i class="fas fa-trash-alt"></i> Xóa mục chọn
            </button>
        </form>
    </div>

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($favorites as $favorite)
            @php $opp = $favorite->opportunity; @endphp
            
            {{-- Semantic Tag: Article --}}
            <article class="group bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative" id="fav-card-{{ $favorite->favorite_id }}">
                
                {{-- Image Container --}}
                <div class="relative h-52 overflow-hidden rounded-t-2xl">
                    {{-- Bulk Checkbox --}}
                    <div class="absolute top-3 left-3 z-20">
                        <input type="checkbox" value="{{ $favorite->favorite_id }}" class="bulk-checkbox w-6 h-6 text-purple-600 border-white rounded shadow-md cursor-pointer focus:ring-0">
                    </div>

                    {{-- Image with SEO Alt --}}
                    @if($opp->image)
                        <img src="{{ asset('storage/' . $opp->image) }}" 
                             alt="Hình ảnh chiến dịch: {{ $opp->title }}" 
                             loading="lazy"
                             class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                    @else
                        <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center text-slate-300">
                            <i class="fas fa-image text-4xl"></i>
                        </div>
                    @endif

                    {{-- Quick Delete Btn --}}
                    <button type="button" onclick="deleteFavorite({{ $favorite->favorite_id }})" aria-label="Xóa khỏi yêu thích"
                            class="absolute top-3 right-3 z-20 w-8 h-8 bg-white/90 backdrop-blur rounded-full text-rose-500 shadow-sm flex items-center justify-center hover:bg-rose-500 hover:text-white transition">
                        <i class="fas fa-times"></i>
                    </button>
                    
                    {{-- Category Badge --}}
                    <div class="absolute bottom-3 left-3 z-10">
                        <span class="px-2 py-1 bg-gray-900/70 backdrop-blur text-white text-[10px] uppercase font-bold rounded-md tracking-wide">
                            {{ $opp->category->category_name ?? 'Chung' }}
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-5 flex flex-col flex-grow">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-2 line-clamp-2 leading-tight group-hover:text-purple-600 transition">
                        <a href="{{ route('opportunities.show', $opp->opportunity_id) }}" title="{{ $opp->title }}">
                            {{ $opp->title }}
                        </a>
                    </h2>

                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                        <i class="fas fa-building text-gray-400"></i>
                        <span class="font-medium truncate">{{ $opp->organization->organization_name }}</span>
                    </div>

                    {{-- Notes Form --}}
                    <div class="mt-auto">
                        <form action="{{ route('volunteer.favorites.notes', $favorite->favorite_id) }}" method="POST" class="relative group/note">
                            @csrf @method('PUT')
                            <label for="note-{{ $favorite->favorite_id }}" class="sr-only">Ghi chú</label>
                            <textarea id="note-{{ $favorite->favorite_id }}" name="notes" rows="2" 
                                      class="w-full bg-gray-50 border-0 rounded-lg p-3 text-sm text-gray-700 focus:ring-2 focus:ring-purple-200 resize-none placeholder-gray-400 transition"
                                      placeholder="Thêm ghi chú..." onblur="this.form.submit()">{{ $favorite->notes }}</textarea>
                            <div class="absolute bottom-2 right-2 text-purple-400 text-xs opacity-0 group-hover/note:opacity-100 transition pointer-events-none">
                                <i class="fas fa-save"></i> Tự động lưu
                            </div>
                        </form>
                    </div>

                    {{-- CTA --}}
                    <div class="mt-4 pt-4 border-t border-gray-100 flex gap-2">
                         <a href="{{ route('opportunities.show', $opp->opportunity_id) }}" 
                           class="flex-1 text-center py-2.5 rounded-xl bg-purple-600 text-white font-bold text-sm hover:bg-purple-700 shadow-md shadow-purple-200 transition">
                            Ứng tuyển
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    {{-- Pagination (Chuẩn SEO: dùng thẻ nav) --}}
    <nav aria-label="Phân trang" class="mt-12">
        {{ $favorites->appends(request()->query())->links() }}
    </nav>

@else
    {{-- Empty State --}}
    <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
        <div class="w-32 h-32 mx-auto bg-purple-50 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-heart-broken text-5xl text-purple-200"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Danh sách đang trống</h2>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">Bạn chưa lưu cơ hội nào. Hãy khám phá và thả tim cho chiến dịch bạn quan tâm nhé.</p>
        <a href="{{ route('opportunities.index') }}" 
           class="inline-flex items-center gap-2 px-8 py-3 bg-purple-600 text-white font-bold rounded-xl shadow-lg hover:bg-purple-700 hover:-translate-y-1 transition">
            <i class="fas fa-search"></i> Tìm cơ hội mới
        </a>
    </div>
@endif

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.bulk-checkbox');
    const bulkBtn = document.getElementById('bulkDeleteBtn');
    const countEl = document.getElementById('selectedCount');
    const bulkInput = document.getElementById('bulkInputIds');
    const bulkForm = document.getElementById('bulkForm');

    function updateBulkState() {
        const checkedBoxes = document.querySelectorAll('.bulk-checkbox:checked');
        const count = checkedBoxes.length;
        countEl.textContent = count;
        
        if(count > 0) {
            bulkBtn.setAttribute('data-active', 'true');
            bulkBtn.disabled = false;
        } else {
            bulkBtn.removeAttribute('data-active');
            bulkBtn.disabled = true;
        }

        // Tạo mảng ID JSON để gửi về Controller
        const ids = Array.from(checkedBoxes).map(cb => cb.value);
        bulkInput.value = JSON.stringify(ids); 
    }

    if(selectAll) {
        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateBulkState();
        });
        checkboxes.forEach(cb => cb.addEventListener('change', updateBulkState));
        
        bulkBtn.addEventListener('click', function() {
            if(confirm(`Bạn có chắc muốn xóa ${countEl.textContent} mục đã chọn?`)) {
                bulkForm.submit();
            }
        });
    }
});

// Single Delete Function (AJAX)
function deleteFavorite(id) {
    if(!confirm('Xóa mục này khỏi danh sách yêu thích?')) return;

    // Dùng fetch để gọi Route Delete
    fetch(`{{ url('/volunteer/favorites') }}/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if(response.ok) {
            const card = document.getElementById(`fav-card-${id}`);
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';
            setTimeout(() => location.reload(), 300); // Reload để cập nhật pagination/count
        } else {
            alert('Lỗi khi xóa. Vui lòng thử lại.');
        }
    });
}
</script>