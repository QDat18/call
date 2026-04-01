<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConnectionController extends Controller
{
    /**
     * Display list of connections
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'accepted');

        $connections = Connection::where(function ($query) {
                $query->where('user_id', auth()->id())
                      ->orWhere('friend_id', auth()->id());
            })
            ->where('status', $status)
            ->with(['user', 'friend'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $acceptedCount = Connection::where(function ($query) {
                $query->where('user_id', auth()->id())
                      ->orWhere('friend_id', auth()->id());
            })
            ->where('status', 'accepted')
            ->count();

        $pendingCount = Connection::where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->count();

        return view('connections.index', compact('connections', 'status', 'acceptedCount', 'pendingCount'));
    }

    /**
     * Send friend request
     */
    public function sendRequest(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,user_id|different:' . auth()->id(),
        ]);

        $friendId = $request->friend_id;
        $userId = auth()->id();

        // Kiểm tra connection tồn tại theo cả hai hướng
        $existing = Connection::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)->where('friend_id', $userId);
        })->first();

        if ($existing) {
            if ($existing->status === 'blocked') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot send request to this user.'
                ], 403);
            }

            if ($existing->status === 'accepted') {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already friends.'
                ], 400);
            }

            if ($existing->status === 'pending') {
                // Nếu request tồn tại theo hướng ngược, tự động accept
                if ($existing->user_id === $friendId && $existing->friend_id === $userId) {
                    $existing->accept();
                    return response()->json([
                        'success' => true,
                        'message' => 'Friend request accepted automatically!',
                        'connection_id' => $existing->connection_id
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Friend request already sent.'
                ], 400);
            }
        }

        // Tạo request mới
        $connection = Connection::create([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'status' => 'pending',
            'action_user_id' => $userId,
            'requested_at' => now(),
        ]);

        broadcast(new \App\Events\FriendRequestSent($connection))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Friend request sent successfully!',
            'connection_id' => $connection->connection_id
        ]);
    }

    /**
     * Accept friend request
     */
    public function acceptRequest($id)
    {
        $connection = Connection::where('connection_id', $id)
            ->where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $connection->accept();

        return response()->json([
            'success' => true,
            'message' => 'Friend request accepted!'
        ]);
    }

    /**
     * Decline friend request
     */
    public function declineRequest($id)
    {
        $connection = Connection::where('connection_id', $id)
            ->where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $connection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Friend request declined.'
        ]);
    }

    /**
     * Remove friend
     */
    public function removeFriend($id)
    {
        $connection = Connection::where('connection_id', $id)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                      ->orWhere('friend_id', auth()->id());
            })
            ->where('status', 'accepted')
            ->firstOrFail();

        $connection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Friend removed successfully.'
        ]);
    }

    /**
     * Block user
     */
    public function blockUser($id)
    {
        $connection = Connection::where('connection_id', $id)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                      ->orWhere('friend_id', auth()->id());
            })
            ->firstOrFail();

        $connection->block();

        return response()->json([
            'success' => true,
            'message' => 'User blocked successfully.'
        ]);
    }

    /**
     * Unblock user
     */
    public function unblockUser($id)
    {
        $connection = Connection::where('connection_id', $id)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                      ->orWhere('friend_id', auth()->id());
            })
            ->where('status', 'blocked')
            ->firstOrFail();

        $connection->unblock();

        return response()->json([
            'success' => true,
            'message' => 'User unblocked successfully.'
        ]);
    }

    /**
     * Get connection status with a user
     */
    public function getConnectionStatus($userId)
    {
        $connection = Connection::where(function ($query) use ($userId) {
            $query->where('user_id', auth()->id())
                  ->where('friend_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('friend_id', auth()->id());
        })->first();

        if (!$connection) {
            return response()->json([
                'status' => 'none',
                'can_send_request' => true
            ]);
        }

        return response()->json([
            'status' => $connection->status,
            'connection_id' => $connection->connection_id,
            'is_sender' => $connection->user_id === auth()->id(),
            'can_accept' => $connection->status === 'pending' && $connection->friend_id === auth()->id(),
            'can_cancel' => $connection->status === 'pending' && $connection->user_id === auth()->id(),
        ]);
    }

    /**
     * Search users to add as friends
     */
    public function searchUsers(Request $request)
{
    $query = $request->get('q');
    
    // Validate minimum length
    if (!$query || strlen($query) < 2) {
        return response()->json([
            'success' => false,
            'message' => 'Please enter at least 2 characters',
            'users' => []
        ]);
    }
    
    // Search users
    $users = User::where('user_id', '!=', auth()->id())
        ->where('is_active', true)
        ->where('user_type', '!=', 'admin')
        ->where(function($q) use ($query) {
            // Search by name
            $q->where('first_name', 'like', "%{$query}%")
              ->orWhere('last_name', 'like', "%{$query}%")
              // Search by email
              ->orWhere('email', 'like', "%{$query}%")
              // Search by full name
              ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"]);
        })
        ->limit(20)
        ->get(['user_id', 'first_name', 'last_name', 'email', 'avatar_url', 'user_type', 'city']);

    // Add connection status for each user
    foreach ($users as $user) {
        $connection = Connection::where(function($q) use ($user) {
                $q->where('user_id', auth()->id())
                  ->where('friend_id', $user->user_id);
            })
            ->orWhere(function($q) use ($user) {
                $q->where('user_id', $user->user_id)
                  ->where('friend_id', auth()->id());
            })
            ->first();

        $user->connection_status = $connection ? $connection->status : 'none';
        $user->connection_id = $connection ? $connection->connection_id : null;
        $user->is_sender = $connection && $connection->user_id === auth()->id();
    }

    return response()->json([
        'success' => true,
        'users' => $users,
        'count' => $users->count()
    ]);
}
}
