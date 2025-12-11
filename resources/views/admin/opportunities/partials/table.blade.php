{{-- File: resources/views/admin/opportunities/partials/table.blade.php --}}
@forelse($opportunities as $opp)
    <tr id="row-{{ $opp->opportunity_id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
        {{-- Cột Thông tin --}}
        <td class="px-6 py-4 max-w-xs">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-white line-clamp-2" title="{{ $opp->title }}">
                        {{ $opp->title }}
                    </p>
                    <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="fas fa-map-marker-alt text-red-400"></i>
                        <span class="truncate max-w-[150px]">{{ $opp->location }}</span>
                    </div>
                </div>
            </div>
        </td>

        {{-- Cột Tổ chức --}}
        <td class="px-6 py-4">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <i class="fas fa-building text-gray-400 text-xs"></i>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $opp->organization->organization_name }}
                    </span>
                </div>
                @if($opp->category)
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border"
                        style="background-color: {{ $opp->category->color }}10; color: {{ $opp->category->color }}; border-color: {{ $opp->category->color }}30">
                        <i class="{{ $opp->category->icon }} mr-1"></i> {{ $opp->category->category_name }}
                    </span>
                @endif
            </div>
        </td>

        {{-- Cột Trạng thái --}}
        <td class="px-6 py-4 text-center">
            @php
                $statusClass = match ($opp->status) {
                    'Active' => 'bg-green-100 text-green-700 border-green-200',
                    'Paused' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    'Completed' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'Cancelled' => 'bg-red-100 text-red-700 border-red-200',
                    default => 'bg-gray-100 text-gray-700 border-gray-200'
                };
            @endphp
            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                {{ $opp->status }}
            </span>
        </td>

        {{-- Cột Thống kê --}}
        <td class="px-6 py-4 text-center">
            <div class="flex flex-col items-center gap-1 text-xs text-gray-600 dark:text-gray-400">
                <span title="Đơn ứng tuyển">
                    <i class="fas fa-file-alt text-blue-500 mr-1"></i> {{ $opp->application_count }} Đơn
                </span>
                <span title="Tình nguyện viên cần tuyển">
                    <i class="fas fa-users text-purple-500 mr-1"></i>
                    {{ $opp->volunteers_registered }}/{{ $opp->volunteers_needed }}
                </span>
            </div>
        </td>

        {{-- Cột Thời gian --}}
        <td class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
            <div>{{ $opp->start_date ? $opp->start_date->format('d/m/Y') : 'N/A' }}</div>
            <div class="text-[10px] text-gray-400">đến
                {{ $opp->end_date ? $opp->end_date->format('d/m/Y') : '...' }}
            </div>
        </td>

        {{-- Cột Hành động --}}
        <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
                <button onclick="viewOpportunity({{ $opp->opportunity_id }})"
                    class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Xem chi tiết">
                    <i class="fas fa-eye"></i>
                </button>
                <button onclick="changeStatus({{ $opp->opportunity_id }})"
                    class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition" title="Đổi trạng thái">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteOpportunity({{ $opp->opportunity_id }})"
                    class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Xóa">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-folder-open text-2xl text-gray-400"></i>
                </div>
                <p class="text-lg font-medium">Không tìm thấy cơ hội nào</p>
                <p class="text-sm">Thử thay đổi bộ lọc hoặc tìm kiếm lại.</p>
            </div>
        </td>
    </tr>
@endforelse