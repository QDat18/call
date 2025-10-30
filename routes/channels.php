<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

/**
 * User Private Channel
 */
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->user_id === (int) $id;
});

/**
 * Conversation Channel - ✅ QUAN TRỌNG CHO REAL-TIME CHAT
 */
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = Conversation::find($conversationId);

    if (!$conversation) {
        return false;
    }

    // Kiểm tra user có phải participant không
    $isParticipant = $conversation->participants()
        ->where('user_id', $user->user_id)
        ->where('is_active', true)
        ->exists();

    if ($isParticipant) {
        // ✅ Return thông tin user để Pusher authorize
        return [
            'user_id' => $user->user_id,
            'name' => $user->first_name . ' ' . $user->last_name
        ];
    }

    return false;
});

/**
 * User Notification Channel
 */
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->user_id === (int) $userId;
});

/**
 * Video Call Channel
 */
Broadcast::channel('video-call.{userId}', function ($user, $userId) {
    return (int) $user->user_id === (int) $userId;
});