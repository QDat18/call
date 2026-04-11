<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\VolunteerOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Jobs\SendNotificationJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    // Danh sách reviews
    public function index(Request $request)
    {
        $query = Review::with(['reviewer', 'reviewee', 'opportunity']);
        
        // Filter theo type
        if ($request->has('type') && $request->type != '') {
            $query->where('review_type', $request->type);
        }
        
        // Filter theo rating
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', $request->rating);
        }
        
        // Filter theo approved status (for admin)
        if (Auth::user()->user_type === 'Admin' && $request->has('approved')) {
            $query->where('is_approved', $request->approved);
        } else {
            // Người dùng thường chỉ thấy reviews đã approved
            $query->where('is_approved', true);
        }
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('review_title', 'like', "%$search%")
                  ->orWhere('review_text', 'like', "%$search%");
            });
        }
        
        $reviews = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('reviews.index', compact('reviews'));
    }

    // Hiển thị form tạo review
    public function create(Request $request)
    {
        $opportunityId = $request->get('opportunity_id');
        $revieweeId = $request->get('reviewee_id');
        
        if (!$opportunityId || !$revieweeId) {
            return back()->with('error', 'Thiếu thông tin cần thiết để tạo review');
        }
        
        $opportunity = VolunteerOpportunity::findOrFail($opportunityId);
        $reviewee = User::findOrFail($revieweeId);
        $user = Auth::user();
        
        // Xác định review type
        $reviewType = $user->user_type === 'Volunteer' 
            ? 'Volunteer to Organization' 
            : 'Organization to Volunteer';
        
        // Kiểm tra xem đã review chưa
        $existingReview = Review::where('reviewer_id', $user->user_id)
            ->where('reviewee_id', $revieweeId)
            ->where('opportunity_id', $opportunityId)
            ->first();
            
        if ($existingReview) {
            return back()->with('error', 'Bạn đã review cho hoạt động này rồi!');
        }
        
        // Kiểm tra quyền review (phải có completed activity)
        if ($user->user_type === 'Volunteer') {
            $hasCompletedActivity = DB::table('volunteer_activities')
                ->where('volunteer_id', $user->user_id)
                ->where('opportunity_id', $opportunityId)
                ->where('status', 'Verified')
                ->exists();
                
            if (!$hasCompletedActivity) {
                return back()->with('error', 'Bạn cần hoàn thành hoạt động trước khi review!');
            }
        } else {
            // Organization review volunteer
            $hasAcceptedApplication = DB::table('applications')
                ->where('opportunity_id', $opportunityId)
                ->where('volunteer_id', $revieweeId)
                ->where('status', 'Accepted')
                ->exists();
                
            if (!$hasAcceptedApplication) {
                return back()->with('error', 'Không thể review tình nguyện viên này!');
            }
        }
        
        return view('reviews.create', compact('opportunity', 'reviewee', 'reviewType'));
    }

    // Lưu review
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewee_id' => 'required|exists:users,user_id',
            'opportunity_id' => 'required|exists:volunteer_opportunities,opportunity_id',
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'required|string|max:100',
            'review_text' => 'required|string|max:1000|min:20'
        ], [
            'review_text.min' => 'Review phải có ít nhất 20 ký tự'
        ]);
        
        $user = Auth::user();
        
        // Xác định review type
        $reviewType = $user->user_type === 'Volunteer' 
            ? 'Volunteer to Organization' 
            : 'Organization to Volunteer';
        
        // Kiểm tra duplicate
        $existingReview = Review::where('reviewer_id', $user->user_id)
            ->where('reviewee_id', $validated['reviewee_id'])
            ->where('opportunity_id', $validated['opportunity_id'])
            ->first();
            
        if ($existingReview) {
            return back()->with('error', 'Bạn đã review cho hoạt động này rồi!');
        }
        
        DB::beginTransaction();
        try {
            // Tạo review
            $review = Review::create([
                'reviewer_id' => $user->user_id,
                'reviewee_id' => $validated['reviewee_id'],
                'opportunity_id' => $validated['opportunity_id'],
                'rating' => $validated['rating'],
                'review_title' => $validated['review_title'],
                'review_text' => $validated['review_text'],
                'review_type' => $reviewType,
                'is_approved' => false // Cần admin approve
            ]);
            
            // Update rating của reviewee
            $this->updateUserRating($validated['reviewee_id']);
            
            // Gửi notification
            $this->sendReviewNotification($review);
            
            DB::commit();
            
            return redirect()->route('reviews.show', $review->review_id)
                ->with('success', 'Đã gửi review thành công! Chờ admin duyệt.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Xem chi tiết review
    public function show($id)
    {
        $review = Review::with(['reviewer', 'reviewee', 'opportunity'])->findOrFail($id);
        
        // Chỉ cho phép xem nếu là reviewer, reviewee, hoặc admin
        $user = Auth::user();
        if ($user->user_type !== 'Admin' && 
            $user->user_id != $review->reviewer_id && 
            $user->user_id != $review->reviewee_id) {
            abort(403, 'Bạn không có quyền xem review này');
        }
        
        return view('reviews.show', compact('review'));
    }

    // Approve review (Admin only)
    public function approve($id)
    {
        $this->authorize('admin');
        
        $review = Review::findOrFail($id);
        
        if ($review->is_approved) {
            return back()->with('info', 'Review này đã được approve rồi!');
        }
        
        DB::beginTransaction();
        try {
            $review->update(['is_approved' => true]);
            
            // Update rating sau khi approve
            $this->updateUserRating($review->reviewee_id);
            
            // Notify reviewee
            SendNotificationJob::dispatch($review->reviewee_id, [
                'type' => 'Review',
                'title' => 'Bạn nhận được review mới',
                'content' => $review->reviewer->first_name . ' đã đánh giá ' . $review->rating . ' sao',
                'related_id' => $review->review_id,
                'related_type' => 'review',
                'action_url' => route('reviews.show', $review->review_id),
                'priority' => 'medium'
            ]);
            
            DB::commit();
            
            // Invalidate stats cache
            Cache::tags(['user_stats'])->flush();
            
            return back()->with('success', 'Đã approve review thành công!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Reject review (Admin only)
    public function reject(Request $request, $id)
    {
        $this->authorize('admin');
        
        $validated = $request->validate([
            'reason' => 'required|string|max:500'
        ]);
        
        $review = Review::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $review->delete();
            
            // Notify reviewer
            SendNotificationJob::dispatch($review->reviewer_id, [
                'type' => 'Review',
                'title' => 'Review của bạn đã bị từ chối',
                'content' => 'Lý do: ' . $validated['reason'],
                'related_id' => $review->review_id,
                'related_type' => 'review',
                'priority' => 'low'
            ]);
            
            DB::commit();
            
            // Invalidate stats cache
            Cache::tags(['user_stats'])->flush();
            
            return back()->with('success', 'Đã reject review!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Mark review as helpful
    public function markHelpful($id)
    {
        $review = Review::findOrFail($id);
        
        if (!$review->is_approved) {
            return back()->with('error', 'Review chưa được approve!');
        }
        
        $review->increment('helpful_count');
        
        return back()->with('success', 'Cảm ơn phản hồi của bạn!');
    }

    // Get reviews for specific user/organization
    public function userReviews($userId)
    {
        $user = User::findOrFail($userId);
        
        $reviews = Review::with(['reviewer', 'opportunity'])
            ->where('reviewee_id', $userId)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Define cache key
        $cacheKey = "user_stats_{$userId}";

        // Tối ưu bằng Single Query Scan và Caching
        $stats = Cache::tags(['reviews', 'user_stats'])->remember($cacheKey, 3600, function() use ($userId) {
            $data = Review::where('reviewee_id', $userId)
                ->where('is_approved', true)
                ->select([
                    DB::raw('COUNT(*) as total'),
                    DB::raw('AVG(rating) as average_rating'),
                    DB::raw('COUNT(CASE WHEN rating = 5 THEN 1 END) as star_5'),
                    DB::raw('COUNT(CASE WHEN rating = 4 THEN 1 END) as star_4'),
                    DB::raw('COUNT(CASE WHEN rating = 3 THEN 1 END) as star_3'),
                    DB::raw('COUNT(CASE WHEN rating = 2 THEN 1 END) as star_2'),
                    DB::raw('COUNT(CASE WHEN rating = 1 THEN 1 END) as star_1'),
                ])
                ->first();

            return [
                'total' => (int) ($data->total ?? 0),
                'average_rating' => round($data->average_rating ?? 0, 2),
                'rating_distribution' => [
                    5 => (int) ($data->star_5 ?? 0),
                    4 => (int) ($data->star_4 ?? 0),
                    3 => (int) ($data->star_3 ?? 0),
                    2 => (int) ($data->star_2 ?? 0),
                    1 => (int) ($data->star_1 ?? 0),
                ]
            ];
        });
        
        return view('reviews.user-reviews', compact('user', 'reviews', 'stats'));
    }

    // Pending reviews for admin
    public function pending()
    {
        $this->authorize('admin');
        
        $reviews = Review::with(['reviewer', 'reviewee', 'opportunity'])
            ->where('is_approved', false)
            ->orderBy('created_at', 'asc')
            ->paginate(20);
        
        return view('reviews.pending', compact('reviews'));
    }

    // Bulk approve reviews
    public function bulkApprove(Request $request)
    {
        $this->authorize('admin');
        
        $validated = $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,review_id'
        ]);
        
        DB::beginTransaction();
        try {
            Review::whereIn('review_id', $validated['review_ids'])
                ->where('is_approved', false)
                ->update(['is_approved' => true]);
            
            // Update ratings for all affected users
            $revieweeIds = Review::whereIn('review_id', $validated['review_ids'])
                ->pluck('reviewee_id')
                ->unique();
                
            foreach ($revieweeIds as $userId) {
                $this->updateUserRating($userId);
            }
            
            DB::commit();
            
            $count = count($validated['review_ids']);
            return back()->with('success', "Đã approve $count reviews thành công!");
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Helper: Update user rating based on approved reviews
    private function updateUserRating($userId)
    {
        $user = User::findOrFail($userId);
        
        // Tính average rating từ approved reviews
        $avgRating = Review::where('reviewee_id', $userId)
            ->where('is_approved', true)
            ->avg('rating');
        
        if ($avgRating !== null) {
            $avgRating = round($avgRating, 2);
            
            if ($user->user_type === 'Volunteer' && $user->volunteerProfile) {
                $user->volunteerProfile->update(['volunteer_rating' => $avgRating]);
            } elseif ($user->user_type === 'Organization' && $user->organization) {
                $user->organization->update(['rating' => $avgRating]);
            }
        }
    }

    // Helper: Send review notification
    private function sendReviewNotification($review)
    {
        // Notify reviewee
        SendNotificationJob::dispatch($review->reviewee_id, [
            'type' => 'Review',
            'title' => 'Bạn có review mới',
            'content' => 'Review đang chờ admin duyệt',
            'related_id' => $review->review_id,
            'related_type' => 'review',
            'action_url' => route('reviews.show', $review->review_id),
            'priority' => 'low'
        ]);
        
        // Notify admin
        $admins = User::where('user_type', 'Admin')->get();
        if ($admins->count() > 0) {
            SendNotificationJob::dispatch($admins->pluck('user_id')->toArray(), [
                'type' => 'Review',
                'title' => 'Review mới cần duyệt',
                'content' => 'Review ' . $review->rating . ' sao cho ' . $review->reviewee->first_name,
                'related_id' => $review->review_id,
                'related_type' => 'review',
                'action_url' => route('reviews.pending'),
                'priority' => 'medium'
            ]);
        }
    }
}