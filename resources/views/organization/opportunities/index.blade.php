@extends('layouts.organization')

@section('title', 'Manage Opportunities')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Opportunities</h1>
            <p class="text-gray-600 mt-1">Manage your volunteer opportunities</p>
        </div>
        <a href="{{ route('organization.opportunities.create') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Opportunity
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Active</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Applications</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['applications'] }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Completed</p>
                    <p class="text-2xl font-bold text-gray-600">{{ $stats['completed'] }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search opportunities..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
                <div>
                    <select name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Paused" {{ request('status') == 'Paused' ? 'selected' : '' }}>Paused</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                        Search
                    </button>
                    <a href="{{ route('organization.opportunities.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow">
        @if($opportunities->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($opportunities as $opportunity)
                
                {{-- [QUAN TRỌNG] TÍNH TOÁN SỐ LƯỢNG ACCEPTED TRỰC TIẾP TRONG VÒNG LẶP --}}
                @php
                    $acceptedCount = $opportunity->applications->where('status', 'Accepted')->count();
                @endphp

                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-xl font-semibold text-gray-800">
                                    {{ $opportunity->title }}
                                </h3>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($opportunity->status == 'Active') bg-green-100 text-green-800
                                    @elseif($opportunity->status == 'Paused') bg-yellow-100 text-yellow-800
                                    @elseif($opportunity->status == 'Completed') bg-gray-100 text-gray-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $opportunity->status }}
                                </span>
                            </div>

                            <p class="text-gray-600 mb-3 line-clamp-2">
                                {{ Str::limit($opportunity->description, 150) }}
                            </p>

                            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $opportunity->start_date ? date('M d, Y', strtotime($opportunity->start_date)) : 'TBD' }}
                                </div>
                                
                                {{-- HIỂN THỊ SỐ LƯỢNG CHÍNH XÁC --}}
                                <div class="flex items-center gap-1 font-medium {{ $acceptedCount >= $opportunity->volunteers_needed ? 'text-green-600' : '' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    {{ $acceptedCount }}/{{ $opportunity->volunteers_needed }} volunteers
                                </div>

                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ $opportunity->view_count }} views
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ $opportunity->application_count }} applications
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 ml-4">
                            <a href="{{ route('organization.opportunities.show', $opportunity->opportunity_id) }}" 
                               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition text-center">
                                View Details
                            </a>
                            <a href="{{ route('organization.opportunities.edit', $opportunity->opportunity_id) }}" 
                               class="px-4 py-2 border border-green-600 text-green-600 hover:bg-green-50 text-sm rounded-lg transition text-center">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $opportunities->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No opportunities found</h3>
                <p class="text-gray-600 mb-4">Start by creating your first volunteer opportunity</p>
                <a href="{{ route('organization.opportunities.create') }}" 
                   class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Opportunity
                </a>
            </div>
        @endif
    </div>
</div>
@endsection