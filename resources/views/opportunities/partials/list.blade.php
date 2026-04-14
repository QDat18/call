<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($opportunities as $opportunity)
        <div class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col h-full">
            
            <div class="p-6 flex flex-col flex-grow">
                {{-- Header Card --}}
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 rounded-full text-[10px] uppercase font-bold tracking-wide text-white flex items-center gap-1"
                          style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}">
                        <i class="{{ $opportunity->category->icon ?? 'fas fa-tag' }}"></i>
                        {{ $opportunity->category->category_name ?? 'General' }}
                    </span>
                    @if(auth()->check() && auth()->user()->user_type === 'Volunteer')
                        <button class="text-gray-300 hover:text-red-500 transition favorite-btn" data-id="{{ $opportunity->opportunity_id }}">
                            <i class="fas fa-heart"></i>
                        </button>
                    @endif
                </div>

                {{-- Title --}}
                <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition">
                    <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}">
                        {{ $opportunity->title }}
                    </a>
                </h3>
                
                <p class="text-sm text-gray-500 mb-4 flex items-center gap-2">
                    <i class="fas fa-building text-gray-300"></i> {{ $opportunity->organization->organization_name }}
                </p>

                {{-- Skills/Meta --}}
                @if($opportunity->processed_skills)
                    <div class="flex flex-wrap gap-1 mb-4">
                        @foreach($opportunity->processed_skills as $skill)
                            <span class="px-2 py-1 bg-gray-50 text-gray-600 text-xs rounded border border-gray-100">{{ trim($skill) }}</span>
                        @endforeach
                        @if($opportunity->remaining_skills_count > 0)
                            <span class="px-2 py-1 bg-gray-50 text-gray-400 text-xs">+{{ $opportunity->remaining_skills_count }}</span>
                        @endif
                    </div>
                @endif

                {{-- [ĐỒNG BỘ] Progress Bar giống hệt trang Show --}}
                <div class="mt-auto mb-5">
                    {{-- Location --}}
                    <div class="flex items-center text-xs text-gray-500 font-medium mb-3">
                        <i class="fas fa-map-marker-alt text-blue-500 mr-1.5"></i> 
                        {{ Str::limit($opportunity->location, 30) }}
                    </div>

                    {{-- Logic tính phần trăm --}}
                    @php
                        $percentage = $opportunity->registration_percentage;
                    @endphp

                    {{-- Thanh tiến độ --}}
                    <div>
                        <div class="flex justify-between text-xs font-medium mb-1.5">
                            <span class="text-gray-600">Đã đăng ký: 
                                <b class="text-indigo-600">{{ $opportunity->volunteers_registered }}/{{ $opportunity->volunteers_needed }}</b>
                            </span>
                            <span class="text-gray-500">
                                {{ round($percentage) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                            {{-- Sử dụng bg-indigo-600 để khớp màu với trang chi tiết --}}
                            <div class="bg-indigo-600 h-full rounded-full transition-all duration-500"
                                 style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Action --}}
                <a href="{{ route('opportunities.show', $opportunity->opportunity_id) }}" 
                   class="block w-full py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold text-center rounded-xl hover:from-indigo-600 hover:to-purple-700 transition shadow-md shadow-indigo-200">
                    Xem chi tiết
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-folder-open text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Không tìm thấy kết quả</h3>
            <p class="text-gray-500">Hãy thử thay đổi từ khóa hoặc bộ lọc.</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-12">
    {{ $opportunities->appends(request()->query())->links() }}
</div>