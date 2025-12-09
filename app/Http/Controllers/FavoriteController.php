<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\VolunteerOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class FavoriteController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('volunteer')->except(['index']);
    // }

    // Danh sách favorites
    public function index(Request $request)
    {
        $user = Auth::user();

        // Eager Load để tránh N+1 Query (Tối ưu tốc độ tải trang - Core Web Vitals)
        $query = Favorite::with(['opportunity.organization', 'opportunity.category'])
            ->where('user_id', $user->user_id);

        // Search (Tìm kiếm chuẩn SEO: Title & Description)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('opportunity', function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereHas('organization', function ($org) use ($search) {
                        $org->where('organization_name', 'like', "%$search%");
                    });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('opportunity', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');

        if ($sortBy === 'title') {
            $query->join('volunteer_opportunities', 'favorites.opportunity_id', '=', 'volunteer_opportunities.opportunity_id')
                ->orderBy('volunteer_opportunities.title', 'asc')
                ->select('favorites.*');
        } else {
            // Mặc định mới nhất trước
            $query->orderBy('created_at', 'desc');
        }

        $favorites = $query->paginate(9)->withQueryString(); // Paginate 9 card cho đẹp grid 3x3

        // Lấy Category dùng Eloquent (Nhẹ hơn)
        $categories = Category::select('category_id', 'category_name')
            ->where('is_active', true)
            ->orderBy('category_name') // Sắp xếp tên A-Z dễ tìm
            ->get();

        // SEO Meta Data (Truyền sang View)
        $seo = [
            'title' => 'Danh sách yêu thích | Volunteer Connect',
            'description' => 'Xem lại và quản lý các cơ hội tình nguyện bạn đã lưu. Đừng bỏ lỡ cơ hội đóng góp cho cộng đồng.',
            'count' => $favorites->total()
        ];

        return view('volunteer.favorites.index', compact('favorites', 'categories', 'seo'));
    }
    // Toggle favorite (thêm/xóa)
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'opportunity_id' => 'required|exists:volunteer_opportunities,opportunity_id'
        ]);

        $user = Auth::user();

        // Kiểm tra opportunity có active không
        $opportunity = VolunteerOpportunity::findOrFail($validated['opportunity_id']);

        if ($opportunity->status !== 'Active') {
            return response()->json([
                'success' => false,
                'message' => 'Không thể favorite opportunity không active!'
            ], 400);
        }

        // Toggle favorite
        $favorite = Favorite::where('user_id', $user->user_id)
            ->where('opportunity_id', $validated['opportunity_id'])
            ->first();

        if ($favorite) {
            // Xóa favorite
            $favorite->delete();

            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Đã xóa khỏi danh sách yêu thích'
            ]);
        } else {
            // Thêm favorite
            Favorite::create([
                'user_id' => $user->user_id,
                'opportunity_id' => $validated['opportunity_id']
            ]);

            return response()->json([
                'success' => true,
                'action' => 'added',
                'message' => 'Đã thêm vào danh sách yêu thích'
            ]);
        }
    }

    // Update notes cho favorite
    public function updateNotes(Request $request, $id)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $favorite = Favorite::findOrFail($id);
        $user = Auth::user();

        // Kiểm tra quyền
        if ($favorite->user_id != $user->user_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa favorite này');
        }

        $favorite->update([
            'notes' => $validated['notes']
        ]);

        return back()->with('success', 'Đã cập nhật ghi chú thành công!');
    }

    // Xóa favorite
    public function destroy($id)
    {
        $favorite = Favorite::findOrFail($id);
        $user = Auth::user();

        // Kiểm tra quyền
        if ($favorite->user_id != $user->user_id) {
            abort(403, 'Bạn không có quyền xóa favorite này');
        }

        $favorite->delete();

        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích!');
    }

    // Bulk delete favorites
    public function bulkDestroy(Request $request)
    {
        // JS gửi lên dạng chuỗi JSON "[1,2,3]", ta cần decode nó
        $ids = $request->input('favorite_ids');

        if (is_string($ids)) {
            $ids = json_decode($ids, true);
        }

        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'Chưa chọn mục nào để xóa.');
        }

        $count = Favorite::whereIn('favorite_id', $ids)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', "Đã xóa $count mục khỏi danh sách!");
    }

    // Kiểm tra xem opportunity có được favorite không
    public function check($opportunityId)
    {
        $user = Auth::user();

        $isFavorited = Favorite::where('user_id', $user->user_id)
            ->where('opportunity_id', $opportunityId)
            ->exists();

        return response()->json([
            'is_favorited' => $isFavorited
        ]);
    }

    // Export favorites to CSV
    public function export()
    {
        $user = Auth::user();

        $favorites = Favorite::with(['opportunity.organization', 'opportunity.category'])
            ->where('user_id', $user->user_id)
            ->get();

        $filename = 'my_favorites_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($favorites) {
            $file = fopen('php://output', 'w');

            // BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Headers
            fputcsv($file, [
                'Opportunity Title',
                'Organization',
                'Category',
                'Location',
                'Start Date',
                'My Notes',
                'Added Date'
            ]);

            foreach ($favorites as $favorite) {
                fputcsv($file, [
                    $favorite->opportunity->title,
                    $favorite->opportunity->organization->organization_name,
                    $favorite->opportunity->category->category_name ?? 'N/A',
                    $favorite->opportunity->location,
                    $favorite->opportunity->start_date,
                    $favorite->notes,
                    $favorite->created_at->format('Y-m-d')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Get favorite count
    public function count()
    {
        $user = Auth::user();

        $count = Favorite::where('user_id', $user->user_id)->count();

        return response()->json([
            'count' => $count
        ]);
    }

    // Clear all favorites (with confirmation)
    public function clearAll()
    {
        $user = Auth::user();

        $count = Favorite::where('user_id', $user->user_id)->delete();

        return back()->with('success', "Đã xóa tất cả $count favorites!");
    }
}
