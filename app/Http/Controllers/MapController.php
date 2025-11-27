<?php

namespace App\Http\Controllers;

use App\Models\VolunteerOpportunity;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index()
    {
        // Lấy danh sách Category để hiển thị bộ lọc
        $categories = Category::select('category_id', 'category_name')->get();
        return view('map.index', compact('categories'));
    }

    public function search(Request $request)
    {
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $radius = $request->get('radius', 10); // Mặc định 10km
        $categoryId = $request->get('category');

        // Query cơ bản: Lấy cơ hội đang mở và còn hạn
        $query = VolunteerOpportunity::with('organization')
            ->where('status', 'Active')
            ->where('application_deadline', '>', now())
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        // Lọc theo Category
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Lọc theo bán kính (nếu có tọa độ người dùng)
        if ($lat && $lng) {
            // Công thức Haversine để tính khoảng cách (km)
            $haversine = "(6371 * acos(cos(radians($lat)) 
                         * cos(radians(latitude)) 
                         * cos(radians(longitude) - radians($lng)) 
                         + sin(radians($lat)) 
                         * sin(radians(latitude))))";

            $query->select('*', DB::raw("$haversine AS distance"))
                  ->having('distance', '<=', $radius)
                  ->orderBy('distance');
        } else {
            // Nếu không có tọa độ, lấy mới nhất
            $query->latest();
        }

        $opportunities = $query->get();

        // Format dữ liệu trả về cho Map
        $data = $opportunities->map(function ($opp) {
            return [
                'id' => $opp->opportunity_id,
                'title' => $opp->title,
                'lat' => (float) $opp->latitude,
                'lng' => (float) $opp->longitude,
                'org_name' => $opp->organization->organization_name ?? 'Unknown Org',
                'image' => $opp->image_url ? asset('storage/' . $opp->image_url) : null, // Giả sử bạn có cột image_url
                'category' => $opp->category->category_name ?? '',
                'link' => route('opportunities.show', $opp->opportunity_id),
                'distance' => isset($opp->distance) ? round($opp->distance, 1) . ' km' : null
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}