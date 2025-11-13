<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerProfileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VolunteerOpportunityController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\VolunteerActivityController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AdminEmailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\OrganizationAnalyticsController;
use App\Http\Controllers\ConnectionController;
use Illuminate\Support\Facades\Broadcast;
use App\Services\AgoraTokenBuilder;


/*
|--------------------------------------------------------------------------
| Public Routes (Không cần đăng nhập)
|--------------------------------------------------------------------------
*/

// ✅ QUAN TRỌNG: Broadcast routes PHẢI ĐẶT TRƯỚC tất cả routes khác
Broadcast::routes(['middleware' => ['web', 'auth']]);

// Home & Static Pages

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/term', function () {
    return view('pages.term');
})->name('terms');

Route::get('/upgrade', function () {
    return view('pages.upgrade');
})->name('upgrade');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/user/{id}/profile', [UserController::class, 'publicProfile'])->name('user.public-profile');

// View posts feed (public)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

// Public Opportunities
Route::get('/opportunities', [VolunteerOpportunityController::class, 'index'])->name('opportunities.index');
Route::get('/opportunities/{id}', [VolunteerOpportunityController::class, 'show'])->name('opportunities.show');

// Public Organizations
Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
Route::get('/organizations/{id}', [OrganizationController::class, 'show'])->name('organizations.show');

// Public Search
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search/advanced', [SearchController::class, 'advancedSearch'])->name('search.advanced');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');
Route::get('/search/category/{id}', [SearchController::class, 'searchByCategory'])->name('search.category');

// Public Reviews
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/user/{userId}', [ReviewController::class, 'userReviews'])->name('reviews.user');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('/register/volunteer', function () {
        return view('auth.register-volunteer');
    })->name('register.volunteer');

    Route::get('/register/organization', function () {
        return view('auth.register-organization');
    })->name('register.organization');

    // Form submissions
    Route::post('/register/volunteer', [AuthController::class, 'registerVolunteer'])
        ->name('register.volunteer.submit');

    Route::post('/register/organization', [AuthController::class, 'registerOrganization'])
        ->name('register.organization.submit');
        
    // Social Login
    Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);
    Route::get('/login/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('/login/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Tất cả user đã đăng nhập)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.edit-profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [UserController::class, 'updateAvatar'])->name('update-avatar');
    Route::get('/users/{id}/profile', [UserController::class, 'profile'])->name('users.profile');

    // Password Change
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change-password.update');

    // Other User Routes
    Route::get('/notifications', [UserController::class, 'notifications'])->name('notifications');
    Route::get('/public-profile/{id}', [UserController::class, 'publicProfile'])->name('public-profile');
    Route::post('/user/deactivate', [UserController::class, 'deactivate'])->name('user.deactivate');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/user/notifications/recent', [UserController::class, 'getRecentNotifications'])->name('user.notifications.recent');
    Route::post('/user/notifications/{notification}/mark-read', [UserController::class, 'markNotificationRead'])->name('user.notifications.mark-read');
    Route::post('/user/notifications/mark-all-read', [UserController::class, 'markAllNotificationsRead'])->name('user.notifications.mark-all-read');

    // ✅ SỬA LỖI: XÓA Route::resource() VÀ CHỈ GIỮ LẠI PREFIX GROUP
    // ❌ XÓA DÒNG NÀY: Route::resource('conversations', ConversationController::class);
    
    // ✅ Conversations Routes - Chỉ giữ group này
    Route::prefix('conversations')->name('conversations.')->group(function () {
        Route::get('/', [ConversationController::class, 'index'])->name('index');
        Route::get('/create', [ConversationController::class, 'create'])->name('create');
        Route::post('/', [ConversationController::class, 'store'])->name('store');
        Route::get('/{id}', [ConversationController::class, 'show'])->name('show');
        Route::put('/{id}', [ConversationController::class, 'update'])->name('update');
        Route::delete('/{id}', [ConversationController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/add-participants', [ConversationController::class, 'addParticipants'])->name('add-participants');
        Route::post('/{id}/leave', [ConversationController::class, 'leave'])->name('leave');
        Route::post('/{id}/archive', [ConversationController::class, 'archive'])->name('archive');
    });

    // Messages Routes
    Route::get('/conversations/{conversationId}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/conversations/{conversationId}/messages', [MessageController::class, 'send'])->name('messages.send');
    Route::post('/conversations/{conversationId}/messages/read', [MessageController::class, 'markRead'])->name('messages.read');
    Route::post('/conversations/{conversationId}/messages/upload', [MessageController::class, 'uploadAttachment'])->name('messages.upload');
    Route::delete('/conversations/{conversationId}/messages/{messageId}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/conversations/{conversationId}/messages/latest', [MessageController::class, 'getLatest'])->name('messages.latest');
    Route::get('/messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('messages.unread-count');
    
    // Connections Routes
    Route::prefix('connections')->name('connections.')->group(function () {
        Route::get('/', [ConnectionController::class, 'index'])->name('index');
        Route::get('/search', [ConnectionController::class, 'searchUsers'])->name('search');
        Route::post('/send-request', [ConnectionController::class, 'sendRequest'])->name('send-request');
        Route::post('/{id}/accept', [ConnectionController::class, 'acceptRequest'])->name('accept');
        Route::post('/{id}/decline', [ConnectionController::class, 'declineRequest'])->name('decline');
        Route::delete('/{id}/remove', [ConnectionController::class, 'removeFriend'])->name('remove');
        Route::post('/{id}/block', [ConnectionController::class, 'blockUser'])->name('block');
        Route::post('/{id}/unblock', [ConnectionController::class, 'unblockUser'])->name('unblock');
        Route::get('/{userId}/status', [ConnectionController::class, 'getConnectionStatus'])->name('status');
    });

    // Reviews
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{id}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/{id}/helpful', [ReviewController::class, 'markHelpful'])->name('reviews.helpful');

    // Posts
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my-posts');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Post Interactions
    Route::post('/posts/{id}/like', [PostController::class, 'toggleLike'])->name('posts.like');
    Route::post('/posts/{id}/comment', [PostController::class, 'addCommentFromForm'])->name('posts.comment');
    Route::post('/posts/{id}/share', [PostController::class, 'share'])->name('posts.share');
    Route::post('/posts/{id}/bookmark', [PostController::class, 'bookmark'])->name('posts.bookmark');
    Route::post('/posts/{id}/report', [PostController::class, 'report'])->name('posts.report');

    Route::post('/comments', [PostController::class, 'storeComment'])->name('comments.store');
    Route::delete('/comments/{id}', [PostController::class, 'deleteComment'])->name('comments.destroy');

    // Bookmarks
    Route::get('/bookmarks', [PostController::class, 'bookmarks'])->name('posts.bookmarks');
    Route::put('/bookmarks/{id}/notes', [PostController::class, 'updateBookmarkNotes'])->name('bookmarks.update-notes');
});

Route::middleware('auth')->prefix('video-calls')->name('video-calls.')->group(function () {
    Route::get('/', [VideoCallController::class, 'index'])->name('index');
    Route::get('/{callId}/join', [VideoCallController::class, 'join'])->name('join');
    Route::get('/{callId}/room', [VideoCallController::class, 'showRoom'])->name('room');
    Route::get('/{callId}/ended', [VideoCallController::class, 'ended'])->name('ended');
    Route::get('/recent', [VideoCallController::class, 'recent'])->name('recent');
});

// ============================================
// VIDEO CALLS API ROUTES
// ============================================
Route::middleware('auth')->prefix('api/video-calls')->name('api.video-calls.')->group(function () {
    Route::post('/initiate', [VideoCallController::class, 'initiate'])->name('initiate');
    Route::post('/accept', [VideoCallController::class, 'accept'])->name('accept');
    Route::post('/decline', [VideoCallController::class, 'decline'])->name('decline');
    Route::post('/end', [VideoCallController::class, 'end'])->name('end');

    // Token cho WebRTC / Agora
    Route::post('/token', [VideoCallController::class, 'token'])->name('call.token');
    Route::get('/{call_id}/status', [VideoCallController::class, 'status'])->name('status');
});
    Route::get('/test-agora-config', function() {
    return response()->json([
        'app_id' => config('services.agora.app_id'),
        'has_certificate' => !empty(config('services.agora.certificate')),
        'certificate_length' => strlen(config('services.agora.certificate') ?? ''),
        'token_expire' => config('services.agora.token_expire'),
        'env_app_id' => env('AGORA_APP_ID'),
        'env_certificate' => env('AGORA_APP_CERTIFICATE'),
    ]);
})->middleware('auth');
/*
|--------------------------------------------------------------------------
| VOLUNTEER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'volunteer'])->prefix('volunteer')->name('volunteer.')->group(function () {

    // Volunteer Dashboard
    Route::get('/dashboard', [DashboardController::class, 'volunteerDashboard'])->name('dashboard');

    // Volunteer Profile
    Route::get('/profile', [VolunteerProfileController::class, 'show'])->name('profile.profile');
    Route::get('/profile/edit', [VolunteerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [VolunteerProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/skills', [VolunteerProfileController::class, 'updateSkills'])->name('profile.skills');
    Route::put('/profile/availability', [VolunteerProfileController::class, 'updateAvailability'])->name('profile.availability');

    // Applications
    Route::get('/applications', [ApplicationController::class, 'myApplications'])->name('applications.my');
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{id}', action: [ApplicationController::class, 'show'])->name('applications.show');
    Route::post('/applications/{id}/withdraw', [ApplicationController::class, 'withdraw'])->name('applications.withdraw');

    // Volunteer Activities
    Route::get('/activities', [VolunteerActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/create', [VolunteerActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [VolunteerActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{id}', [VolunteerActivityController::class, 'show'])->name('activities.show');
    Route::post('/activities/{id}/dispute', [VolunteerActivityController::class, 'dispute'])->name('activities.dispute');
    Route::get('/activities/export', [VolunteerActivityController::class, 'export'])->name('activities.export');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::put('/favorites/{id}/notes', [FavoriteController::class, 'updateNotes'])->name('favorites.notes');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/favorites/bulk-destroy', [FavoriteController::class, 'bulkDestroy'])->name('favorites.bulk-destroy');
    Route::get('/favorites/export', [FavoriteController::class, 'export'])->name('favorites.export');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
});

/*
|--------------------------------------------------------------------------
| ORGANIZATION ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('organization')->name('organization.')->group(function () {
    Route::get('/profile', [OrganizationController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [OrganizationController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [OrganizationController::class, 'update'])->name('profile.update');
    
    Route::get('/opportunities', [VolunteerOpportunityController::class, 'organizationIndex'])->name('opportunities.index');
    Route::get('/opportunities/create', [VolunteerOpportunityController::class, 'create'])->name('opportunities.create');
    Route::post('/opportunities', [VolunteerOpportunityController::class, 'store'])->name('opportunities.store');
    Route::get('/opportunities/{id}/edit', [VolunteerOpportunityController::class, 'edit'])->name('opportunities.edit');
    Route::put('/opportunities/{id}', [VolunteerOpportunityController::class, 'update'])->name('opportunities.update');
    Route::delete('/opportunities/{id}', [VolunteerOpportunityController::class, 'destroy'])->name('opportunities.destroy');
    Route::post('/opportunities/{id}/pause', [VolunteerOpportunityController::class, 'pause'])->name('opportunities.pause');
    Route::post('/opportunities/{id}/resume', [VolunteerOpportunityController::class, 'resume'])->name('opportunities.resume');
    
    Route::get('/applications', [ApplicationController::class, 'organizationIndex'])->name('applications.index');
    Route::put('/applications/{id}/review', [ApplicationController::class, 'review'])->name('applications.review');
    
    Route::get('/volunteers', [OrganizationController::class, 'volunteers'])->name('volunteers.index');
    
    Route::get('/activities', [VolunteerActivityController::class, 'organizationIndex'])->name('activities.index');
    Route::post('/activities/{id}/verify', [VolunteerActivityController::class, 'verify'])->name('activities.verify');
    
    Route::get('/organizations', [OpportunityController::class, 'organizationsList'])->name('organizations.index');
    Route::get('/organizations/{id}', [OpportunityController::class, 'organizationDetail'])->name('organizations.show');

    Route::get('/analytics', [OrganizationAnalyticsController::class, 'index'])->name('analytics');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    Route::get('/users/export', [AdminController::class, 'exportUsers'])->name('users.export');
    
    Route::get('/organizations', [AdminController::class, 'organizations'])->name('organizations.index');
    Route::get('/organizations/{id}', [AdminController::class, 'showOrganization'])->name('organizations.show');
    Route::get('/organizations/verification', [AdminController::class, 'pendingOrganizations'])->name('organizations.verification');
    Route::get('/organizations/export', [AdminController::class, 'exportOrganizations'])->name('organizations.export');
    
    Route::get('/opportunities', [AdminController::class, 'opportunities'])->name('opportunities.index');
    Route::get('/opportunities/{id}', [AdminController::class, 'showOpportunity'])->name('opportunities.show');
    Route::delete('/opportunities/{id}', [AdminController::class, 'deleteOpportunity'])->name('opportunities.destroy');
    Route::get('/opportunities/export', [AdminController::class, 'exportOpportunities'])->name('opportunities.export');
    
    Route::get('/applications', [AdminController::class, 'index'])->name('applications.index');
    Route::get('/applications-export', [AdminController::class, 'exportApplications'])->name('applications.export');
    Route::get('/applications/{id}', [AdminController::class, 'showApplication'])->name('applications.show');
    
    Route::get('/activities', [AdminController::class, 'activities'])->name('activities.index');
    Route::get('/activities/{id}', [AdminController::class, 'showActivity'])->name('activities.show');
    Route::get('/activities/disputes', [AdminController::class, 'disputedActivities'])->name('activities.disputes');
    Route::post('/activities/{id}/resolve-dispute', [AdminController::class, 'resolveDispute'])->name('activities.resolve-dispute');
    
    Route::get('/reviews', [ReviewController::class, 'pending'])->name('reviews.index');
    Route::get('/reviews/all', [AdminController::class, 'allReviews'])->name('reviews.all');
    Route::get('/reviews/pending', [ReviewController::class, 'pending'])->name('reviews.pending');
    Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('/reviews/bulk-approve', [ReviewController::class, 'bulkApprove'])->name('reviews.bulk-approve');
    
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::get('/categories/create', function () {
        return view('admin.categories.create');
    })->name('categories.create');
    Route::post('/categories', [AdminController::class, 'categoriesStore'])->name('categories.store');
    Route::get('/categories/{id}/edit', function ($id) {
        $category = \App\Models\Category::withCount('opportunities')->findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    })->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'categoriesUpdate'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'categoriesDestroy'])->name('categories.destroy');
    Route::post('/categories/{id}/toggle', [AdminController::class, 'categoriesToggle'])->name('categories.toggle');
    
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/chart-data', [AnalyticsController::class, 'getChartData'])->name('analytics.chart-data');
    Route::get('/analytics/impact', [AnalyticsController::class, 'impactReport'])->name('analytics.impact');
    Route::post('/analytics/custom-report', [AnalyticsController::class, 'customReport'])->name('analytics.custom-report');
    Route::post('/analytics/export', [AnalyticsController::class, 'exportReport'])->name('analytics.export');
    Route::post('/analytics/clear-cache', [AnalyticsController::class, 'clearCache'])->name('analytics.clear-cache');
    Route::get('/analytics/reports', [AnalyticsController::class, 'reports'])->name('analytics.reports');
    
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    Route::prefix('emails')->name('emails.')->group(function () {
        Route::post('/send', [AdminEmailController::class, 'sendEmail'])->name('send');
        Route::get('/history', [AdminEmailController::class, 'history'])->name('history');
        Route::get('/templates', [AdminEmailController::class, 'getTemplates'])->name('templates');
    });
    
    Route::post('/organizations/{id}/approve', [AdminController::class, 'approveOrganization'])->name('organizations.approve');
    Route::post('/organizations/{id}/reject', [AdminController::class, 'rejectOrganization'])->name('organizations.reject');
    
    Route::post('/users/{id}/activate', [AdminController::class, 'activateUser'])->name('users.activate');
    Route::post('/users/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
    
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    
    Route::get('/posts', [PostController::class, 'adminIndex'])->name('posts.index');
    Route::get('/posts/pending', [PostController::class, 'pending'])->name('posts.pending');
    Route::post('/posts/{id}/approve', [PostController::class, 'approve'])->name('posts.approve');
    Route::post('/posts/{id}/reject', [PostController::class, 'reject'])->name('posts.reject');
    Route::post('/posts/{id}/pin', [PostController::class, 'togglePin'])->name('posts.pin');
    Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');
    
    Route::get('/posts/reports', [PostController::class, 'reports'])->name('posts.reports');
    Route::post('/reports/{id}/resolve', [PostController::class, 'resolveReport'])->name('reports.resolve');
});

/*
|--------------------------------------------------------------------------
| Shared Routes (Applications & Activities)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::post('/posts/{id}/bookmark', [PostController::class, 'bookmark'])->name('posts.bookmark');
    Route::get('/bookmarks', [PostController::class, 'bookmarks'])->name('posts.bookmarks');
    Route::put('/bookmarks/{id}/notes', [PostController::class, 'updateBookmarkNotes'])->name('bookmarks.update-notes');
    
    Route::get('/volunteer-activities', [VolunteerActivityController::class, 'index'])->name('volunteer-activities.index');
    Route::get('/volunteer-activities/create', [VolunteerActivityController::class, 'create'])->name('volunteer-activities.create');
    Route::post('/volunteer-activities', [VolunteerActivityController::class, 'store'])->name('volunteer-activities.store');
    Route::get('/volunteer-activities/{id}', [VolunteerActivityController::class, 'show'])->name('volunteer-activities.show');
    Route::post('/volunteer-activities/{id}/verify', [VolunteerActivityController::class, 'verify'])->name('volunteer-activities.verify');
    Route::get('/volunteer-activities/export', [VolunteerActivityController::class, 'export'])->name('volunteer-activities.export');
});

/*
|--------------------------------------------------------------------------
| API-like Routes (for AJAX calls)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('api')->name('api.')->group(function () {
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites/check/{opportunityId}', [FavoriteController::class, 'check'])->name('favorites.check');
    Route::get('/favorites/count', [FavoriteController::class, 'count'])->name('favorites.count');
    
    Route::get('/messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('messages.unread-count');
    Route::post('/messages/typing', [MessageController::class, 'typing'])->name('messages.typing');
    Route::get('/conversations/{conversationId}/messages/search', [MessageController::class, 'search'])->name('messages.search');
    
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    
    Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');
    Route::get('/search/popular', [SearchController::class, 'popularSearches'])->name('search.popular');
    Route::get('/search/trending', [SearchController::class, 'trendingOpportunities'])->name('search.trending');
    
});
/*
|--------------------------------------------------------------------------
| Fallback Route (404 Page)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('errors.404');
});
Route::get('/test-agora-token', function () {
    $appId = config('services.agora.app_id');
    $appCertificate = config('services.agora.certificate');
    $channelName = 'test_' . time();
    $uid = Auth::id() ?? rand(1, 999999);
    $expireTime = 3600; // 1h
    $expireTimestamp = time() + $expireTime;

    try {
        $token = AgoraTokenBuilder::generateToken(
            $appId,
            $appCertificate,
            $channelName,
            $uid,
            $expireTimestamp
        );

        return response()->json([
            'success' => true,
            'app_id' => $appId,
            'channel' => $channelName,
            'uid' => $uid,
            'token' => $token,
            'expires_at' => date('Y-m-d H:i:s', $expireTimestamp)
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});