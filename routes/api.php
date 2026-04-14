<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Lưu ý: Laravel sẽ tự động thêm tiền tố "/api" cho tất cả các route ở đây.
| URL thực tế sẽ là: website.com/api/search/suggestions
|
*/

// ============================================
// PUBLIC API (Không cần đăng nhập)
// ============================================
Route::prefix('search')->name('api.search.')->group(function () {
    Route::get('/suggestions', [SearchController::class, 'suggestions'])->name('suggestions');
    Route::get('/quick', [SearchController::class, 'quickSearch'])->name('quick');
    Route::get('/filter', [SearchController::class, 'filterOpportunities'])->name('filter');
    Route::get('/nearby', [SearchController::class, 'searchByLocation'])->name('nearby');
    Route::get('/statistics', [SearchController::class, 'searchStatistics'])->name('statistics');
    Route::get('/trending', [SearchController::class, 'trendingOpportunities'])->name('trending');
    Route::get('/popular', [SearchController::class, 'popularSearches'])->name('popular');
    Route::post('/save', [SearchController::class, 'saveSearch'])->name('save');
});

// ============================================
// PROTECTED API (Bắt buộc đăng nhập)
// ============================================
// Sử dụng auth:sanctum hỗ trợ tốt cho cả SPA Web (AJAX) và Mobile App API
Route::middleware('auth:sanctum')->name('api.')->group(function () {

    // Connections API
    Route::prefix('connections')->name('connections.')->group(function () {
        Route::get('/search', [ConnectionController::class, 'searchUsers'])->name('search');
        Route::post('/send-request', [ConnectionController::class, 'sendRequest'])->name('send-request');
        Route::post('/{id}/accept', [ConnectionController::class, 'acceptRequest'])->name('accept');
        Route::post('/{id}/decline', [ConnectionController::class, 'declineRequest'])->name('decline');
        Route::delete('/{id}/remove', [ConnectionController::class, 'removeFriend'])->name('remove');
        Route::post('/{id}/block', [ConnectionController::class, 'blockUser'])->name('block');
        Route::post('/{id}/unblock', [ConnectionController::class, 'unblockUser'])->name('unblock');
        Route::get('/{userId}/status', [ConnectionController::class, 'getConnectionStatus'])->name('status');
    });

    // Video Calls API
    Route::prefix('call')->name('call.')->group(function () {
        Route::post('/token', [VideoCallController::class, 'token'])->name('token');
        Route::post('/accept', [VideoCallController::class, 'accept'])->name('accept');
        Route::post('/decline', [VideoCallController::class, 'decline'])->name('decline');
        Route::post('/end', [VideoCallController::class, 'end'])->name('end');
    });

    // Favorites API
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::post('/toggle', [FavoriteController::class, 'toggle'])->name('toggle');
        Route::get('/check/{opportunityId}', [FavoriteController::class, 'check'])->name('check');
        Route::get('/count', [FavoriteController::class, 'count'])->name('count');
    });

    // Messages API
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::post('/send', [MessageController::class, 'store'])->name('send');
        Route::get('/unread-count', [MessageController::class, 'getUnreadCount'])->name('unread-count');
        Route::post('/typing', [MessageController::class, 'typing'])->name('typing');
        Route::get('/conversations/{conversationId}/search', [MessageController::class, 'search'])->name('search');
    });

    // Notifications API
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
    });

});
