<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VolunteerProfile;
use App\Models\Organization;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function profile()
    {
        /** @var User $user */
        $user = Auth::User();
        $user->last_login_at = now();
        $user->save();

        if (!$user) {
            abort(401, 'User not authenticated');
        }

        // Load relationships
        if ($user->isVolunteer()) {
            $user->load('volunteerProfile');
        } elseif ($user->isOrganization()) {
            $user->load('organization');
        }

        return view('user.profile', compact('user'));
    }

    public function editProfile()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isVolunteer()) {
            $user->load('volunteerProfile');
        } elseif ($user->isOrganization()) {
            $user->load('organization');
        }

        return view('user.edit-profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:15|unique:users,phone,' . $user->user_id . ',user_id',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:Male,Female,Other',
            'city' => 'required|string|max:50',
            'district' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar_url) {
                    Storage::disk('public')->delete($user->avatar_url);
                }

                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar_url = $avatarPath;
            }

            // Update user info
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'city' => $request->city,
                'district' => $request->district,
                'address' => $request->address,
            ]);

            return redirect()->route('profile')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update profile. Please try again.')
                ->withInput();
        }
        // catch (\Exception $e) {
        //     dd($e->getMessage(), $e->getCode());
        // } catch (\Exception $e) {
        //     dd($e->getMessage(), $e->getCode());
        // }
    }


    public function showChangePasswordForm()
    {
        $user = Auth::user();
        return view('user.change-password', compact('user'));
    }

    public function changePassword(Request $request)
    {
        /** @var User $user */
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Current password is required',
            'new_password.required' => 'New password is required',
            'new_password.min' => 'New password must be at least 8 characters',
            'new_password.confirmed' => 'Password confirmation does not match',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Current password is incorrect');
        }

        // Check if new password is same as current
        if (Hash::check($request->new_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'New password must be different from current password');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Password changed successfully!');
    }

    /**
     * Deactivate account
     */
    public function deactivateAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $user = Auth::user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Password is incorrect');
        }

        // Deactivate account
        $user->update(['is_active' => false]);

        // Logout user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Your account has been deactivated successfully.');
    }

    /**
     * Show public profile
     */
    public function publicProfile($userId)
    {
        $user = User::with(['volunteerProfile', 'organization'])
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->firstOrFail();

        // Get reviews received
        $reviews = $user->receivedReviews()
            ->where('is_approved', true)
            ->with('reviewer')
            ->latest()
            ->paginate(10);

        // Get volunteer activities if volunteer
        $activities = null;
        if ($user->isVolunteer()) {
            $activities = $user->activities()
                ->where('status', 'Verified')
                ->with('opportunity')
                ->latest()
                ->take(5)
                ->get();
        }

        // Get opportunities if organization
        $opportunities = null;
        if ($user->isOrganization()) {
            $opportunities = $user->organization->opportunities()
                ->where('status', 'Active')
                ->latest()
                ->take(6)
                ->get();
        }

        $posts = $user->posts()->latest()->paginate(10);
        $mostPopularPost = $user->posts()
            ->withCount(['likes', 'comments'])
            ->orderBy('likes_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->first();

        $recentActivity = [];
        foreach ($user->posts()->latest()->take(3)->get() as $post) {
            $recentActivity[] = [
                'icon' => 'edit',
                'color' => 'blue',
                'description' => "Posted: " . $post->title,
                'time' => $post->created_at->diffForHumans(),
            ];
        }
        // foreach ($user->comments()->latest()->take(3)->get() as $comment) {
        //     $recentActivity[] = [
        //         'icon' => 'comment',
        //         'color' => 'green',
        //         'description' => "Commented: " . Str::limit($comment->content, 50),
        //         'time' => $comment->created_at->diffForHumans(),
        //     ];
        // }
        if ($user->isVolunteer()) {
            foreach ($user->activities()->latest()->take(3)->get() as $activity) {
                $recentActivity[] = [
                    'icon' => 'hands-helping',
                    'color' => 'purple',
                    'description' => "Participated in: " . $activity->opportunity->title,
                    'time' => $activity->created_at->diffForHumans(),
                ];
            }
        }

        // Sort by newest first
        usort($recentActivity, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        return view('user.public-profile', compact('user', 'reviews', 'activities', 'opportunities', 'posts', 'mostPopularPost', 'recentActivity'));
    }

    /**
     * Get user statistics
     */
    public function getStatistics()
    {
        $user = Auth::user();
        $stats = [];

        if ($user->isVolunteer()) {
            $stats = [
                'total_hours' => $user->volunteerProfile->total_volunteer_hours ?? 0,
                'rating' => $user->volunteerProfile->volunteer_rating ?? 0,
                'applications' => $user->applications()->count(),
                'accepted_applications' => $user->applications()->where('status', 'Accepted')->count(),
                'completed_activities' => $user->ativities()->where('status', 'Verified')->count(),
                'reviews_count' => $user->receivedReviews()->where('is_approved', true)->count(),
            ];
        } elseif ($user->isOrganization()) {
            $org = $user->organization;
            $stats = [
                'volunteer_count' => $org->volunteer_count ?? 0,
                'rating' => $org->rating ?? 0,
                'total_opportunities' => $org->total_opportunities ?? 0,
                'active_opportunities' => $org->opportunities()->where('status', 'Active')->count(),
                'pending_applications' => $org->opportunities()
                    ->join('applications', 'volunteer_opportunities.opportunity_id', '=', 'applications.opportunity_id')
                    ->where('applications.status', 'Pending')
                    ->count(),
                'reviews_count' => $user->receivedReviews()->where('is_approved', true)->count(),
            ];
        }

        return response()->json($stats);
    }

    /**
     * Search users (for admin or messaging)
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type'); // 'volunteer' or 'organization'

        $users = User::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                    ->orWhere('last_name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%");
            });

        if ($type) {
            $users->where('user_type', ucfirst($type));
        }

        $users = $users->select('user_id', 'first_name', 'last_name', 'email', 'avatar_url', 'user_type')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    /**
     * Get user notifications
     */
    public function notifications()
    {
        $notifications = Auth::user()->notifications()
            ->latest()
            ->paginate(20);

        return view('user.notifications', compact('notifications'));
    }

    /**
     * Mark notification as read
     */
    public function markNotificationRead($notificationId)
    {
        $notification = Auth::user()->notifications()
            ->findOrFail($notificationId);

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()
            ->with('success', 'All notifications marked as read');
    }

    /**
     * Delete notification
     */
    public function deleteNotification($notificationId)
    {
        $notification = Auth::user()->notifications()
            ->findOrFail($notificationId);

        $notification->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get recent notifications for navbar
     */
    public function getRecentNotifications()
    {
        /** @var User $user */
        $user = Auth::user();

        $notifications = $user->notifications()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'notification_id' => $notification->notification_id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'is_read' => (bool) $notification->is_read,
                    'action_url' => $notification->action_url,
                    'action_text' => $notification->action_text,
                    'created_at' => $notification->created_at->toISOString(),
                ];
            });

        $unreadCount = $user->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
}
