<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($opportunities as $opportunity)
        <div class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col h-full">
            
            <div class="p-6 flex flex-col flex-grow">
                {{-- Header Card --}}
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 rounded-full text-[10px] uppercase font-bold tracking-wide text-white"
                          style="background-color: {{ $opportunity->category->color ?? '#3B82F6' }}">
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
                @if($opportunity->required_skills)
                    @php
                        $rawSkills = $opportunity->required_skills;
                        $skills = is_array($rawSkills) ? $rawSkills : explode(',', $rawSkills);
                        $skills = array_filter($skills, function($v) { return !empty(trim($v)); });
                    @endphp
                    <div class="flex flex-wrap gap-1 mb-4 mt-auto">
                        @foreach($skills as $skill)
                            @if($loop->index < 2)
                            <span class="px-2 py-1 bg-gray-50 text-gray-600 text-xs rounded border border-gray-100">{{ trim($skill) }}</span>
                            @endif
                        @endforeach
                        @if(count($skills) > 2)
                            <span class="px-2 py-1 bg-gray-50 text-gray-400 text-xs">+{{ count($skills)-2 }}</span>
                        @endif
                    </div>
                @endif

                <div class="flex flex-wrap gap-2 mb-4 mt-auto">
                    <span class="px-3 py-1 bg-gray-50 text-gray-600 text-xs rounded-lg font-medium">
                        <i class="fas fa-map-marker-alt text-red-400 mr-1"></i> {{ Str::limit($opportunity->location, 12) }}
                    </span>
                    <span class="px-3 py-1 bg-gray-50 text-gray-600 text-xs rounded-lg font-medium">
                        <i class="fas fa-users text-blue-400 mr-1"></i> {{ $opportunity->volunteers_registered }}/{{ $opportunity->volunteers_needed }}
                    </span>
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