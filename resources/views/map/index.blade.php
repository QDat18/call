@extends('layouts.app')

@section('title', 'Bản đồ Tình nguyện')

@section('content')
<div class="relative w-full h-[calc(100vh-64px)] overflow-hidden">
    
    <div id="volunteer-map" class="w-full h-full z-0"></div>

    <div class="absolute top-4 left-4 z-[1000] w-80 bg-white/95 backdrop-blur-md p-5 rounded-2xl shadow-2xl border border-white/20">
        <div class="mb-4">
            <h1 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-map-marked-alt text-indigo-600 mr-2"></i> Khám Phá
            </h1>
            <p class="text-xs text-gray-500">Tìm cơ hội tình nguyện quanh bạn</p>
        </div>

        <button onclick="locateUser()" 
                class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition shadow-lg hover:shadow-indigo-500/30 flex items-center justify-center mb-4">
            <i class="fas fa-location-arrow mr-2"></i> Tìm quanh tôi
        </button>

        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600 font-medium">Bán kính</span>
                    <span class="text-indigo-600 font-bold"><span id="radius-val">10</span> km</span>
                </div>
                <input type="range" id="radius" min="1" max="50" value="10" 
                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                    <span>1km</span>
                    <span>50km</span>
                </div>
            </div>

            <div>
                <label class="text-sm text-gray-600 font-medium mb-1 block">Danh mục</label>
                <select id="category-filter" class="w-full p-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="status-msg" class="mt-4 text-xs text-center text-gray-500 min-h-[1.5em]"></div>
    </div>

    <div id="map-loader" class="absolute inset-0 bg-white/80 z-[999] flex items-center justify-center hidden">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
<style>
    /* Custom Popup Style */
    .leaflet-popup-content-wrapper {
        border-radius: 16px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .leaflet-popup-content {
        margin: 0;
        width: 280px !important;
    }
    .leaflet-container {
        font-family: 'Inter', sans-serif;
    }
    /* Custom User Marker */
    .user-pulse {
        background: rgba(79, 70, 229, 0.4);
        border-radius: 50%;
        height: 14px;
        width: 14px;
        position: absolute;
        left: 50%;
        top: 50%;
        margin: -11px 0 0 -11px;
        animation: pulsate 1.5s ease-out;
        animation-iteration-count: infinite; 
        opacity: 0;
        z-index: 1;
    }
    @keyframes pulsate {
        0% { transform: scale(0.1, 0.1); opacity: 0.0; }
        50% { opacity: 1.0; }
        100% { transform: scale(3, 3); opacity: 0.0; }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

<script>
    let map, userMarker, radiusCircle;
    let markersCluster = L.markerClusterGroup({
        showCoverageOnHover: false,
        maxClusterRadius: 50
    });
    let userLat = null;
    let userLng = null;

    // 1. Khởi tạo bản đồ
    document.addEventListener('DOMContentLoaded', () => {
        // Mặc định: Trung tâm Việt Nam hoặc Hà Nội
        map = L.map('volunteer-map').setView([16.047079, 108.206230], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        map.addLayer(markersCluster);

        // Load dữ liệu ban đầu (toàn quốc)
        fetchOpportunities();
    });

    // 2. Định vị người dùng
    function locateUser() {
        const status = document.getElementById('status-msg');
        const loader = document.getElementById('map-loader');
        
        status.textContent = "Đang lấy vị trí...";
        loader.classList.remove('hidden');

        if (!navigator.geolocation) {
            status.textContent = "Trình duyệt không hỗ trợ định vị.";
            loader.classList.add('hidden');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;
                
                // Vẽ marker người dùng
                updateUserMarker(userLat, userLng);
                
                // Tìm kiếm xung quanh
                fetchOpportunities();
                
                status.textContent = "Đã tìm thấy vị trí của bạn.";
                loader.classList.add('hidden');
            },
            (error) => {
                console.error(error);
                status.textContent = "Không thể lấy vị trí. Hãy kiểm tra GPS.";
                loader.classList.add('hidden');
            }
        );
    }

    // 3. Vẽ Marker người dùng & Vòng tròn
    function updateUserMarker(lat, lng) {
        const radiusKm = document.getElementById('radius').value;

        // Xóa cũ
        if (userMarker) map.removeLayer(userMarker);
        if (radiusCircle) map.removeLayer(radiusCircle);

        // Icon người dùng (chấm xanh)
        const userIcon = L.divIcon({
            className: 'custom-user-marker',
            html: '<div class="w-4 h-4 bg-indigo-600 rounded-full border-2 border-white shadow-md relative"><div class="user-pulse"></div></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });

        userMarker = L.marker([lat, lng], {icon: userIcon}).addTo(map);
        
        // Vẽ vòng tròn
        radiusCircle = L.circle([lat, lng], {
            color: '#4F46E5',
            fillColor: '#4F46E5',
            fillOpacity: 0.05,
            weight: 1,
            radius: radiusKm * 1000
        }).addTo(map);

        map.fitBounds(radiusCircle.getBounds());
    }

    // 4. Gọi API lấy dữ liệu
    async function fetchOpportunities() {
        const radius = document.getElementById('radius').value;
        const category = document.getElementById('category-filter').value;
        
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
                if (userLat && userLng) {
                    updateUserMarker(userLat, userLng); // Update lại vòng tròn nếu bán kính đổi
                }
            }
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    // 5. Hiển thị Markers lên bản đồ
    function renderMarkers(data) {
        markersCluster.clearLayers();

        data.forEach(opp => {
            // Nội dung Popup đẹp mắt
            const popupContent = `
                <div class="flex flex-col">
                    <div class="h-32 w-full bg-gray-100 relative">
                        <img src="${opp.image || 'https://via.placeholder.com/300x150?text=Volunteer'}" 
                             class="w-full h-full object-cover" 
                             onerror="this.src='https://via.placeholder.com/300x150?text=No+Image'">
                        ${opp.distance ? `<span class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-0.5 rounded-full backdrop-blur-sm"><i class="fas fa-location-arrow mr-1"></i>${opp.distance}</span>` : ''}
                    </div>
                    <div class="p-4">
                        <div class="text-xs font-bold text-indigo-600 mb-1 uppercase tracking-wide">${opp.category}</div>
                        <h3 class="text-base font-bold text-gray-900 mb-1 leading-tight">
                            <a href="${opp.link}" class="hover:text-indigo-600 transition">${opp.title}</a>
                        </h3>
                        <p class="text-xs text-gray-500 mb-3 flex items-center">
                            <i class="fas fa-building mr-1.5"></i> ${opp.org_name}
                        </p>
                        <a href="${opp.link}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 rounded-lg transition shadow-sm hover:shadow-md">
                            Xem Chi Tiết
                        </a>
                    </div>
                </div>
            `;

            const marker = L.marker([opp.lat, opp.lng])
                .bindPopup(popupContent);
                
            markersCluster.addLayer(marker);
        });
    }

    // Event Listeners
    document.getElementById('radius').addEventListener('input', (e) => {
        document.getElementById('radius-val').textContent = e.target.value;
    });

    // Debounce cho slider để tránh gọi API quá nhiều khi kéo
    let timeoutId;
    document.getElementById('radius').addEventListener('change', () => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(fetchOpportunities, 300);
    });

    document.getElementById('category-filter').addEventListener('change', fetchOpportunities);

</script>
@endpush
@endsection