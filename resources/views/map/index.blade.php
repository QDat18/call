@extends('layouts.app')

@section('title', 'Bản đồ Tình nguyện - Volunteer Connect')

@section('content')
    <div class="relative w-full h-[calc(100vh-64px)] overflow-hidden bg-gray-100">

        {{-- Map Container --}}
        <div id="volunteer-map" class="w-full h-full z-0 outline-none"></div>

        {{-- Control Panel --}}
        <div
            class="absolute top-4 left-4 z-[500] w-[340px] max-w-[calc(100vw-32px)] bg-white/95 backdrop-blur-xl p-5 rounded-3xl shadow-2xl border border-white/40 transition-all duration-300">
            {{-- Header --}}
            <div class="mb-5 border-b border-gray-100 pb-4">
                <h1 class="text-xl font-extrabold text-gray-800 flex items-center gap-2">
                    <span class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                        <i class="fas fa-map-marked-alt"></i>
                    </span>
                    Bản đồ Tình nguyện
                </h1>
                <p class="text-xs text-gray-500 mt-1 pl-11">Kết nối yêu thương trên mọi miền tổ quốc</p>
            </div>

            {{-- Locate Button --}}
            <button onclick="locateUser()" id="locate-btn"
                class="group w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-indigo-200 hover:shadow-indigo-300 flex items-center justify-center mb-5 overflow-hidden relative">
                <span
                    class="absolute w-full h-full bg-white/20 -translate-x-full group-hover:translate-x-full transition-transform duration-700 skew-x-12"></span>
                <i class="fas fa-location-arrow mr-2 animate-bounce"></i> Tìm quanh tôi
            </button>

            {{-- Filters --}}
            <div class="space-y-5">
                {{-- Radius Slider --}}
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div class="flex justify-between text-sm mb-3">
                        <span class="text-gray-700 font-semibold flex items-center gap-2">
                            <i class="fas fa-bullseye text-indigo-500"></i> Bán kính tìm kiếm
                        </span>
                        <span
                            class="text-indigo-600 font-bold bg-indigo-50 px-2 py-0.5 rounded text-xs border border-indigo-100">
                            <span id="radius-val">10</span> km
                        </span>
                    </div>
                    <input type="range" id="radius" min="1" max="100" value="10"
                        class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600 hover:accent-indigo-500 transition-all">
                    <div class="flex justify-between text-[10px] text-gray-400 mt-2 font-medium">
                        <span>1 km</span>
                        <span>100 km</span>
                    </div>
                </div>

                {{-- Category Select --}}
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block ml-1">Danh mục hoạt
                        động</label>
                    <div class="relative">
                        <i class="fas fa-filter absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <select id="category-filter"
                            class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm appearance-none cursor-pointer hover:border-gray-300 transition-colors">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                        <i
                            class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                    </div>
                </div>
            </div>

            {{-- Status Message --}}
            <div id="status-msg"
                class="mt-4 text-xs font-medium text-center text-gray-500 min-h-[1.5em] flex items-center justify-center gap-1">
                <i class="fas fa-info-circle text-blue-400"></i> <span>Sẵn sàng tìm kiếm</span>
            </div>
        </div>

        {{-- Loading Overlay --}}
        <div id="map-loader"
            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-[1000] flex flex-col items-center justify-center hidden transition-opacity">
            <div class="w-16 h-16 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin mb-4 shadow-xl">
            </div>
            <p class="text-indigo-900 font-bold animate-pulse">Đang tải bản đồ...</p>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
        <style>
            /* 1. Popup Style Modern */
            .leaflet-popup-content-wrapper {
                border-radius: 20px;
                padding: 0;
                overflow: hidden;
                box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.5);
            }

            .leaflet-popup-content {
                margin: 0;
                width: 300px !important;
                font-family: 'Inter', system-ui, sans-serif;
            }

            .leaflet-popup-tip {
                background: white;
                box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.2);
            }

            .leaflet-container a.leaflet-popup-close-button {
                top: 10px;
                right: 10px;
                color: white;
                background: rgba(0, 0, 0, 0.3);
                border-radius: 50%;
                width: 24px;
                height: 24px;
                line-height: 24px;
                text-align: center;
                font: 16px/24px Tahoma, Verdana, sans-serif;
                text-shadow: none;
                transition: all 0.2s;
            }

            .leaflet-container a.leaflet-popup-close-button:hover {
                background: rgba(0, 0, 0, 0.6);
                color: white;
            }

            /* 2. Marker Clusters */
            .marker-cluster-small,
            .marker-cluster-medium,
            .marker-cluster-large {
                background-color: rgba(79, 70, 229, 0.2);
            }

            .marker-cluster-small div,
            .marker-cluster-medium div,
            .marker-cluster-large div {
                background-color: #4F46E5;
                color: white;
                font-weight: bold;
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.3);
            }

            /* 3. User Location Pulse Animation */
            .user-pulse {
                display: block;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background: #3B82F6;
                border: 3px solid white;
                box-shadow: 0 0 0 rgba(59, 130, 246, 0.4);
                animation: pulse-blue 2s infinite;
                position: relative;
            }

            @keyframes pulse-blue {
                0% {
                    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
                }

                70% {
                    box-shadow: 0 0 0 15px rgba(59, 130, 246, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
                }
            }
        </style>
    @endpush

    @push('scripts')
        {{-- Load thư viện --}}
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

        <script>
            // 1. ĐỔI TÊN BIẾN để tránh xung đột
            let volunteerMap = null;
            let userMarker = null;
            let radiusCircle = null;
            let markersCluster = null;
            let userLat = null;
            let userLng = null;
            let isMapInitialized = false;

            document.addEventListener('DOMContentLoaded', () => {
                initMap();
            });

            function initMap() {
                if (isMapInitialized) return;

                // 2. Khởi tạo bản đồ
                volunteerMap = L.map('volunteer-map', {
                    zoomControl: false,
                    attributionControl: false
                }).setView([15.8, 108.0], 6);

                L.control.zoom({ position: 'bottomright' }).addTo(volunteerMap);

                // 3. SỬ DỤNG GOOGLE MAPS LAYER
                // lyrs=m: Standard Road Map (Bản đồ đường phố chuẩn)
                // lyrs=s: Satellite (Vệ tinh)
                // lyrs=y: Hybrid (Vệ tinh + Tên đường)
                const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                });

                googleStreets.addTo(volunteerMap);

                // 4. Khởi tạo Cluster
                markersCluster = L.markerClusterGroup({
                    showCoverageOnHover: false,
                    maxClusterRadius: 40,
                    animate: true
                });

                // 5. Thêm Cluster vào Map NGAY LẬP TỨC (Fix lỗi _zoom undefined)
                volunteerMap.addLayer(markersCluster);

                isMapInitialized = true;

                // 6. Load dữ liệu
                fetchOpportunities();
            }

            // --- LOGIC ĐỊNH VỊ ---
            function locateUser() {
                if (!volunteerMap) return;

                const status = document.getElementById('status-msg');
                const loader = document.getElementById('map-loader');
                const btn = document.getElementById('locate-btn');

                status.innerHTML = '<i class="fas fa-spinner fa-spin text-indigo-500"></i> Đang lấy vị trí GPS...';
                loader.classList.remove('hidden');
                btn.disabled = true;
                btn.classList.add('opacity-75', 'cursor-not-allowed');

                if (!navigator.geolocation) {
                    status.innerHTML = '<i class="fas fa-exclamation-triangle text-red-500"></i> Trình duyệt không hỗ trợ GPS.';
                    loader.classList.add('hidden');
                    resetBtn(btn);
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLat = position.coords.latitude;
                        userLng = position.coords.longitude;

                        updateUserMarker(userLat, userLng);
                        fetchOpportunities();

                        status.innerHTML = '<i class="fas fa-check-circle text-green-500"></i> Đã cập nhật vị trí.';
                        loader.classList.add('hidden');
                        resetBtn(btn);
                    },
                    (error) => {
                        console.error(error);
                        let msg = "Lỗi định vị.";
                        if (error.code === 1) msg = "Bạn đã từ chối quyền truy cập vị trí.";

                        status.innerHTML = `<i class="fas fa-times-circle text-red-500"></i> ${msg}`;
                        loader.classList.add('hidden');
                        resetBtn(btn);
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            }

            function resetBtn(btn) {
                btn.disabled = false;
                btn.classList.remove('opacity-75', 'cursor-not-allowed');
            }

            function updateUserMarker(lat, lng) {
                if (!volunteerMap) return;

                const radiusKm = document.getElementById('radius').value;

                if (userMarker) volunteerMap.removeLayer(userMarker);
                if (radiusCircle) volunteerMap.removeLayer(radiusCircle);

                const userIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: "<div class='user-pulse'></div>",
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                });

                userMarker = L.marker([lat, lng], { icon: userIcon }).addTo(volunteerMap);

                radiusCircle = L.circle([lat, lng], {
                    color: '#4F46E5',
                    fillColor: '#4F46E5',
                    fillOpacity: 0.1,
                    weight: 1,
                    radius: radiusKm * 1000
                }).addTo(volunteerMap);

                volunteerMap.fitBounds(radiusCircle.getBounds(), { padding: [50, 50] });
            }

            // --- LOGIC FETCH DATA ---
            async function fetchOpportunities() {
                if (!markersCluster || !volunteerMap) return;

                const radius = document.getElementById('radius').value;
                const category = document.getElementById('category-filter').value;
                const status = document.getElementById('status-msg');

                status.innerHTML = '<i class="fas fa-sync fa-spin text-gray-400"></i> Đang tìm kiếm...';

                let url = `{{ route('api.map.search') }}?radius=${radius}`;
                if (userLat && userLng) {
                    url += `&lat=${userLat}&lng=${userLng}`;
                }
                if (category) {
                    url += `&category=${category}`;
                }

                try {
                    const response = await fetch(url);
                    const res = await response.json();

                    if (res.success) {
                        renderMarkers(res.data);

                        const count = res.data.length;
                        status.innerHTML = count > 0
                            ? `<span class="text-green-600 font-bold">${count}</span> cơ hội được tìm thấy.`
                            : `<span class="text-orange-500">Không tìm thấy cơ hội nào.</span>`;
                    }
                } catch (error) {
                    console.error("Error fetching data:", error);
                    status.innerHTML = `<span class="text-red-500">Lỗi kết nối.</span>`;
                }
            }

            function renderMarkers(data) {
                if (!markersCluster) return;
                markersCluster.clearLayers();

                data.forEach(opp => {
                    const popupContent = `
                        <div class="flex flex-col group cursor-pointer" onclick="window.location.href='${opp.link}'">
                            <div class="h-36 w-full bg-gray-200 relative overflow-hidden">
                                <img src="${opp.image || 'https://via.placeholder.com/300x150?text=Volunteer+Connect'}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" 
                                     onerror="this.src='https://via.placeholder.com/300x150?text=No+Image'">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                                ${opp.distance ? `<span class="absolute bottom-3 right-3 bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold px-2 py-1 rounded-lg flex items-center shadow-sm"><i class="fas fa-location-arrow mr-1 text-[10px]"></i> ${opp.distance}</span>` : ''}

                                <span class="absolute top-3 left-3 bg-indigo-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm uppercase tracking-wider">
                                    ${opp.category}
                                </span>
                            </div>

                            <div class="p-4 bg-white">
                                <h3 class="text-base font-bold text-gray-800 mb-1 leading-snug line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                    ${opp.title}
                                </h3>

                                <div class="flex items-center text-xs text-gray-500 mb-3 border-b border-gray-100 pb-3">
                                    <i class="fas fa-building text-gray-300 mr-1.5 text-sm"></i>
                                    <span class="truncate">${opp.org_name}</span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-semibold text-indigo-600">Xem chi tiết <i class="fas fa-arrow-right ml-1"></i></span>
                                </div>
                            </div>
                        </div>
                    `;

                    const marker = L.marker([opp.lat, opp.lng])
                        .bindPopup(popupContent, {
                            closeButton: true,
                            maxWidth: 300,
                            minWidth: 280
                        });

                    markersCluster.addLayer(marker);
                });
            }

            // Event Listeners
            const radiusInput = document.getElementById('radius');
            const radiusVal = document.getElementById('radius-val');

            if (radiusInput) {
                radiusInput.addEventListener('input', (e) => {
                    radiusVal.textContent = e.target.value;
                });

                let timeoutId;
                radiusInput.addEventListener('change', () => {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => {
                        if (userLat && userLng) {
                            updateUserMarker(userLat, userLng);
                            fetchOpportunities();
                        } else {
                            fetchOpportunities();
                        }
                    }, 300);
                });
            }

            const categoryFilter = document.getElementById('category-filter');
            if (categoryFilter) {
                categoryFilter.addEventListener('change', fetchOpportunities);
            }

        </script>
    @endpush
@endsection