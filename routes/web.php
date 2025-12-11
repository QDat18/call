<?php

use Illuminate\Http\Request;
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
use App\Http\Controllers\Admin\OrganizationVerificationController;
use App\Http\Controllers\Admin\DonationCampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Http\Controllers\Admin\ReviewModerationController;
use App\Http\Controllers\Admin\ActivityVerificationController;
use App\Http\Controllers\Admin\ReportGenerationController;
use App\Http\Controllers\MapController;
use App\Models\VnLocation;
/*
|--------------------------------------------------------------------------
| Broadcast Routes - MUST BE FIRST
|--------------------------------------------------------------------------
*/

Broadcast::routes(['middleware' => ['web', 'auth']]);

/*
|--------------------------------------------------------------------------
| Public Routes (Không cần đăng nhập)
|--------------------------------------------------------------------------
*/

// Home & Static Pages
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/contact', function (Request $request) {
    // 1. Validate dữ liệu
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string',
        'message' => 'required|string',
    ]);

    // 2. Gửi email thực sự (Admin Email nhận tin)
    // Thay 'admin@volunteerconnect.vn' bằng email quản trị viên của bạn
    try {
        Mail::to('hoangquangdat182005@gmail.com')->send(new ContactFormMail($validated));
    } catch (\Exception $e) {
        // Log lỗi nếu gửi mail thất bại (tùy chọn)
        \Log::error('Contact mail error: ' . $e->getMessage());
    }

    // 3. Redirect về trang cũ kèm thông báo
    return back()->with('success', 'Tin nhắn của bạn đã được gửi thành công! Chúng tôi sẽ phản hồi sớm nhất.');
})->name('contact.submit');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/term', function () {
    return view('pages.term');
})->name('terms');

Route::get('/upgrade', function () {
    return view('pages.upgrade');
})->name('upgrade');

// Public User Profiles
Route::get('/user/{id}/profile', [UserController::class, 'publicProfile'])->name('user.public-profile');

// Posts (Public)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show')->whereNumber('id');

// Opportunities (Public)
Route::get('/opportunities', [VolunteerOpportunityController::class, 'index'])->name('opportunities.index');
Route::get('/opportunities/{id}', [VolunteerOpportunityController::class, 'show'])->name('opportunities.show');

// Organizations (Public)
Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
Route::get('/organizations/{id}', [OrganizationController::class, 'show'])->name('organizations.show');

// Search Routes (Public)
Route::prefix('search')->name('search.')->group(function () {
    Route::get('/', [SearchController::class, 'index'])->name('index');
    Route::get('/results', [SearchController::class, 'search'])->name('results');
    Route::get('/advanced', [SearchController::class, 'advancedSearch'])->name('advanced');
    Route::get('/category/{id}', [SearchController::class, 'searchByCategory'])->name('category');
    Route::get('/location', [SearchController::class, 'searchByLocation'])->name('location');
    Route::get('/suggestions', [SearchController::class, 'suggestions'])->name('suggestions');
    Route::get('/quick', [SearchController::class, 'quickSearch'])->name('quick');
    Route::get('/trending', [SearchController::class, 'trendingOpportunities'])->name('trending');
    Route::get('/popular', [SearchController::class, 'popularSearches'])->name('popular');
});


// Reviews (Public)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/user/{userId}', [ReviewController::class, 'userReviews'])->name('reviews.user');

// Reviews (Public)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/user/{userId}', [ReviewController::class, 'userReviews'])->name('reviews.user');

// === BẮT ĐẦU: THÊM ROUTE CHIẾN DỊCH QUYÊN GÓP ===
// Trang chi tiết chiến dịch (Public)
Route::get('/campaigns/{id}', [DonationController::class, 'show'])->name('campaign.show');
Route::get('/map', [MapController::class, 'index'])->name('map.index');
Route::get('/api/map/search', [MapController::class, 'search'])->name('api.map.search');




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

    Route::post('/register/volunteer', [AuthController::class, 'registerVolunteer'])->name('register.volunteer.submit');
    Route::post('/register/organization', [AuthController::class, 'registerOrganization'])->name('register.organization.submit');

    // Social Login - Google
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

    // Social Login - Facebook
    Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Logout
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::get('/public-profile/{id}', [UserController::class, 'publicProfile'])->name('public-profile');

    // Password Change
    // Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
    Route::post('/user/send-reset-link', [UserController::class, 'sendResetLinkEmail'])
        ->name('user.send-reset-link');
    // Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change-password.update');
    // Route::post('/user/send-verification-code', [UserController::class, 'sendVerificationCode'])->name('user.send-verification-code');
    // User Deactivation
    Route::post('/user/deactivate', [UserController::class, 'deactivate'])->name('user.deactivate');

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::get('/recent', [UserController::class, 'getRecentNotifications'])->name('recent');
        Route::post('/{notification}/mark-read', [UserController::class, 'markNotificationRead'])->name('mark-read');
        Route::post('/mark-all-read', [UserController::class, 'markAllNotificationsRead'])->name('mark-all-read');
        Route::post('/delete-read', [NotificationController::class, 'deleteAllRead'])->name('delete-read');
    });

    // Conversations
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

    Route::get('/conversations/{conversationId}/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/conversations/{conversationId}/messages', [MessageController::class, 'send'])->name('messages.send');
    Route::post('/conversations/{conversationId}/messages/read', [MessageController::class, 'markRead'])->name('messages.read');
    Route::post('/conversations/{conversationId}/messages/upload', [MessageController::class, 'uploadAttachment'])->name('messages.upload');
    Route::delete('/conversations/{conversationId}/messages/{messageId}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/conversations/{conversationId}/messages/latest', [MessageController::class, 'getLatest'])->name('messages.latest');
    Route::get('/messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('messages.unread-count');

    // Connections (Friends)
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

    // Video Calls
    Route::prefix('video-calls')->name('video-calls.')->group(function () {
        Route::get('/', [VideoCallController::class, 'index'])->name('index');
        Route::get('/{callId}/join', [VideoCallController::class, 'join'])->name('join');
        Route::get('/{callId}/room', [VideoCallController::class, 'showRoom'])->name('room');
        Route::get('/{callId}/ended', [VideoCallController::class, 'ended'])->name('ended');
        Route::get('/recent', [VideoCallController::class, 'recent'])->name('recent');
    });

    // Reviews
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/create', [ReviewController::class, 'create'])->name('create');
        Route::post('/', [ReviewController::class, 'store'])->name('store');
        Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
        Route::post('/{id}/helpful', [ReviewController::class, 'markHelpful'])->name('helpful');
    });

    // Posts
    Route::middleware(['auth'])->prefix('posts')->name('posts.')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('create'); // /posts/create
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/my-posts', [PostController::class, 'myPosts'])->name('my-posts');

        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit')->whereNumber('id');
        Route::put('/{id}', [PostController::class, 'update'])->name('update')->whereNumber('id');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy')->whereNumber('id');

        // Interactions
        Route::post('/{id}/like', [PostController::class, 'toggleLike'])->name('like')->whereNumber('id');
        Route::post('/{id}/comment', [PostController::class, 'addCommentFromForm'])->name('comment')->whereNumber('id');
        Route::post('/{id}/share', [PostController::class, 'share'])->name('share')->whereNumber('id');
        Route::post('/{id}/bookmark', [PostController::class, 'bookmark'])->name('bookmark')->whereNumber('id');
        Route::post('/{id}/report', [PostController::class, 'report'])->name('report')->whereNumber('id');
    });

    // Comments
    Route::post('/comments', [PostController::class, 'storeComment'])->name('comments.store');
    Route::delete('/comments/{id}', [PostController::class, 'deleteComment'])->name('comments.destroy');
    Route::post('/comments/{id}/like', [PostController::class, 'toggleCommentLike'])->name('comments.like');
    // Bookmarks
    Route::get('/bookmarks', [PostController::class, 'bookmarks'])->name('bookmarks');
    Route::put('/bookmarks/{id}/notes', [PostController::class, 'updateBookmarkNotes'])->name('bookmarks.update-notes');
});


/*
|--------------------------------------------------------------------------
| Verification Routes 
|--------------------------------------------------------------------------
*/
Route::get('/email/verify/{token}', [AuthController::class, 'verifyEmail'])->name('verify-email');

// Route gửi lại email xác thực (nếu cần)
Route::post('/email/resend', [AuthController::class, 'resendVerificationEmail'])->name('email.resend');
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
    // Danh sách đơn của tôi
    Route::get('/applications', [ApplicationController::class, 'myApplications'])
        ->name('applications.my');

    // Form ứng tuyển (có ID cơ hội)
    // Route::get('/create/{opportunity}', [ApplicationController::class, 'create'])->name('create');
    Route::get('/applications/create/{opportunity}', [ApplicationController::class, 'create'])
        ->name('applications.create');
    // Gửi đơn
    Route::post('/applications', [ApplicationController::class, 'store'])
        ->name('applications.store');

    // Xem chi tiết đơn
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])
        ->name('applications.show');

    // Rút đơn
    Route::post('/applications/{application}/withdraw', [ApplicationController::class, 'withdraw'])
        ->name('applications.withdraw');
    Route::post('/contact', [ApplicationController::class, 'storeContact'])
        ->name('contact.store');
    Route::get('/activities', [VolunteerActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/create', [VolunteerActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [VolunteerActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{id}', [VolunteerActivityController::class, 'show'])->name('activities.show');
    Route::post('/activities/{id}/dispute', [VolunteerActivityController::class, 'dispute'])->name('activities.dispute');
    Route::get('/activities/export', [VolunteerActivityController::class, 'export'])->name('activities.export');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');
    Route::put('/favorites/{id}/notes', [FavoriteController::class, 'updateNotes'])->name('favorites.notes');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/favorites/bulk-destroy', [FavoriteController::class, 'bulkDestroy'])->name('favorites.bulk-destroy');
    Route::get('/favorites/export', [FavoriteController::class, 'export'])->name('favorites.export');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
});/*
|--------------------------------------------------------------------------
| ORGANIZATION ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\OrganizationMiddleware::class])
    ->prefix('organization')
    ->name('organization.')
    ->group(function () {

        // Dashboard & Stats
        Route::get('/dashboard', [DashboardController::class, 'organizationDashboard'])->name('dashboard');
        Route::get('/statistics', [DashboardController::class, 'statistics'])->name('statistics');
        Route::get('/activity-feed', [DashboardController::class, 'activityFeed'])->name('activity-feed');
        Route::get('/quick-stats', [DashboardController::class, 'quickStats'])->name('quick-stats');

        // Profile & Verification
        Route::get('/profile', [OrganizationController::class, 'profile'])->name('profile.show');
        Route::get('/profile/edit', [OrganizationController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [OrganizationController::class, 'update'])->name('profile.update');
        Route::post('/profile/certificate/delete', [OrganizationController::class, 'deleteCertificate'])->name('profile.certificate.delete');

        Route::get('/verification', [OrganizationController::class, 'showVerification'])->name('verification.request');
        Route::post('/verification', [OrganizationController::class, 'submitVerification'])->name('verification.submit');

        // Opportunities (Cơ hội)
        Route::prefix('opportunities')->name('opportunities.')->group(function () {
            Route::get('/', [OpportunityController::class, 'index'])->name('index');
            Route::get('/create', [OpportunityController::class, 'create'])->name('create');
            Route::post('/', [OpportunityController::class, 'store'])->name('store');
            Route::get('/{id}', [OpportunityController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [OpportunityController::class, 'edit'])->name('edit');
            Route::put('/{id}', [OpportunityController::class, 'update'])->name('update');
            Route::delete('/{id}', [OpportunityController::class, 'destroy'])->name('destroy');

            // Các action đặc biệt
            Route::post('/{id}/pause', [OpportunityController::class, 'pause'])->name('pause');
            Route::post('/{id}/resume', [OpportunityController::class, 'activate'])->name('resume'); // Hàm activate trong controller
            Route::post('/{id}/complete', [OpportunityController::class, 'complete'])->name('complete');
            Route::post('/{id}/cancel', [OpportunityController::class, 'cancel'])->name('cancel');
        });

        // Applications (Đơn đăng ký)
        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [ApplicationController::class, 'organizationIndex'])->name('index');
            Route::get('/received', [ApplicationController::class, 'organizationIndex'])->name('received');
            Route::get('/{id}', [ApplicationController::class, 'showOrganizationApplication'])->name('show');

            // Xử lý đơn
            Route::put('/{id}/review', [ApplicationController::class, 'review'])->name('review');
            Route::put('/{id}/accept', [ApplicationController::class, 'accept'])->name('accept');
            Route::put('/{id}/reject', [ApplicationController::class, 'reject'])->name('reject');
            Route::post('/{id}/interview', [ApplicationController::class, 'scheduleInterview'])->name('interview');
            Route::post('/{id}/notes', [ApplicationController::class, 'saveNotes'])->name('notes');
        });

        // Activities (Hoạt động/Giờ làm)
        Route::prefix('activities')->name('activities.')->group(function () {
            Route::get('/', [ActivityController::class, 'organizationIndex'])->name('index');
            Route::get('/{id}', [ActivityController::class, 'show'])->name('show');

            // Xác minh
            Route::post('/{id}/verify', [ActivityController::class, 'verify'])->name('verify');
            Route::post('/{id}/dispute', [ActivityController::class, 'dispute'])->name('dispute');
            Route::post('/bulk-verify', [ActivityController::class, 'bulkVerify'])->name('bulk-verify');
            Route::get('/export', [ActivityController::class, 'export'])->name('export');
            Route::get('/stats', [ActivityController::class, 'statistics'])->name('stats');
        });

        // Volunteers List
        Route::get('/volunteers', [OrganizationController::class, 'volunteers'])->name('volunteers.index');
        Route::get('/volunteers/export', [OrganizationController::class, 'exportVolunteers'])->name('volunteers.export');
        Route::get('/volunteers/{id}', [OrganizationController::class, 'showVolunteer'])->name('volunteers.show');


        // Route Contact
        Route::post('/volunteers/contact', [OrganizationController::class, 'contactVolunteer'])->name('volunteers.contact');
        // Analytics (Báo cáo)
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/', [OrganizationAnalyticsController::class, 'index'])->name('index');
            Route::get('/data', [OrganizationAnalyticsController::class, 'getData'])->name('data');
            Route::get('/export', [OrganizationAnalyticsController::class, 'export'])->name('export');
        });
    });

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminController::class, 'users'])->name('index');
            Route::get('/create', [AdminController::class, 'createUser'])->name('create');
            Route::post('/', [AdminController::class, 'storeUser'])->name('store');
            Route::get('/export', [AdminController::class, 'exportUsers'])->name('export');
            // --- CÁC ROUTE MỚI CẦN THÊM ---
            Route::get('/download-template', [AdminController::class, 'downloadUserTemplate'])->name('download-template');
            Route::post('/import', [AdminController::class, 'importUsers'])->name('import');
            // ------------------------------

            Route::get('/{id}', [AdminController::class, 'showUser'])->name('show');
            Route::get('/{id}/edit', [AdminController::class, 'editUser'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateUser'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('destroy');
            Route::post('/{id}/activate', [AdminController::class, 'activateUser'])->name('activate');
            Route::post('/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('deactivate');


            // Route bulk action
            Route::post('/bulk-action', [AdminController::class, 'userBulkAction'])->name('bulk-action');
        });

        // Organizations
        // Route::prefix('organizations')->name('organizations.')->group(function () {
        //     Route::get('/', [AdminController::class, 'organizations'])->name('index');
        //     Route::get('/{id}', [AdminController::class, 'showOrganization'])->name('show');
        //     Route::get('/verification', [AdminController::class, 'pendingOrganizations'])->name('verification');
        //     Route::post('/{id}/approve', [AdminController::class, 'approveOrganization'])->name('approve');
        //     Route::post('/{id}/reject', [AdminController::class, 'rejectOrganization'])->name('reject');
        //     Route::get('/export', [AdminController::class, 'exportOrganizations'])->name('export');
        // });
        Route::prefix('organizations')->name('organizations.')->group(function () {
            // Route chính, có thể giữ lại AdminController
            Route::get('/', [AdminController::class, 'organizations'])->name('index');

            // === CẬP NHẬT CÁC ROUTE XÉT DUYỆT ===

            // Trỏ 'verification' đến controller mới
            Route::get('/verification', [OrganizationVerificationController::class, 'index'])->name('verification');
            Route::get('/export-options', [AdminController::class, 'showExportOptions'])->name('export.options');
            Route::get('/export', [AdminController::class, 'organizationsExport'])->name('export');
            // Trỏ 'show' đến controller mới (vì nó hiển thị chi tiết để duyệt)
            Route::get('/{id}', [OrganizationVerificationController::class, 'show'])->name('show');

            // Trỏ 'approve' đến controller mới
            Route::post('/{id}/approve', [OrganizationVerificationController::class, 'approve'])->name('approve');

            // Trỏ 'reject' đến controller mới
            Route::post('/{id}/reject', [OrganizationVerificationController::class, 'reject'])->name('reject');

            // === THÊM DÒNG NÀY ĐỂ CÓ THỂ XÓA ===
            Route::delete('/{id}', [OrganizationVerificationController::class, 'destroy'])->name('destroy');

            // Thêm route cho việc yêu cầu tài liệu
            Route::post('/{id}/request-documents', [OrganizationVerificationController::class, 'requestDocuments'])->name('request-documents');

            // Route export có thể giữ lại

        });

        // Opportunities
        Route::prefix('opportunities')->name('opportunities.')->group(function () {

            // 1. Route tĩnh (Đặt lên đầu tiên để không bị hiểu nhầm là ID)
            Route::get('/export', [AdminController::class, 'exportView'])->name('export');
            Route::post('/download', [AdminController::class, 'processExport'])->name('download');

            // 2. Route Index
            Route::get('/', [AdminController::class, 'opportunities'])->name('index');

            // API Update Status (Sửa lại đường dẫn cho khớp với JS)
            Route::post('/{id}/status', [AdminController::class, 'opportunitiesUpdateStatus'])->name('updateStatus');

            // Show chi tiết (Lưu ý: Chỉ để 1 route show duy nhất trỏ về showOpportunity)
            Route::get('/{id}', [AdminController::class, 'showOpportunity'])->name('show');

            // Delete
            Route::delete('/{id}', [AdminController::class, 'deleteOpportunity'])->name('destroy');
        });

        // Applications
        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            // [QUAN TRỌNG] Đưa các route cụ thể lên trước
            Route::get('/export', [AdminController::class, 'exportApplications'])->name('export');

            // [QUAN TRỌNG] Route có tham số {id} phải để cuối cùng
            Route::get('/{id}', [AdminController::class, 'showApplication'])->name('show');
        });

        // Activities
        Route::prefix('activities')->name('activities.')->group(function () {
            // Route Pending (Thêm mới)
            Route::get('/pending', [AdminController::class, 'pendingActivities'])->name('pending');

            Route::get('/', [AdminController::class, 'activities'])->name('index');
            Route::get('/disputes', [AdminController::class, 'disputedActivities'])->name('disputes');
            Route::post('/bulk-verify', [ActivityVerificationController::class, 'bulkVerify'])->name('bulkVerify');
            // Route {id} nên để cuối cùng để tránh xung đột
            Route::get('/{id}', [AdminController::class, 'showActivity'])->name('show');

            Route::post('/{id}/resolve-dispute', [AdminController::class, 'resolveDispute'])->name('resolve-dispute');

            // Thêm route Verify và Dispute action (nếu chưa có)
            Route::post('/{id}/verify', [ActivityVerificationController::class, 'verify'])->name('verify');
            Route::post('/{id}/dispute', [ActivityVerificationController::class, 'dispute'])->name('dispute');
        });

        // Reviews
        Route::prefix('reviews')->name('reviews.')->group(function () {
            // Trang danh sách review (kết hợp cả moderate và index)
            Route::get('/', [ReviewModerationController::class, 'index'])->name('index');
            Route::get('/moderate', [ReviewModerationController::class, 'index'])->name('moderate'); // Để khớp với code trong Controller

            // Chi tiết review
            Route::get('/{id}', [ReviewModerationController::class, 'show'])->name('show');

            // Các hành động duyệt/từ chối
            Route::post('/{id}/approve', [ReviewModerationController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [ReviewModerationController::class, 'reject'])->name('reject');

            // Hành động hàng loạt
            Route::post('/bulk-action', [ReviewModerationController::class, 'bulkAction'])->name('bulkAction');
        });
        // Categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [AdminController::class, 'categories'])->name('index');
            Route::get('/create', function () {
                return view('admin.categories.create');
            })->name('create');
            Route::post('/', [AdminController::class, 'categoriesStore'])->name('store');
            Route::get('/{id}/edit', function ($id) {
                $category = \App\Models\Category::withCount('opportunities')->findOrFail($id);
                return view('admin.categories.edit', compact('category'));
            })->name('edit');
            Route::get('/{id}/opportunities', [AdminController::class, 'getCategoryOpportunities'])->name('opportunities');
            Route::put('/{id}', [AdminController::class, 'categoriesUpdate'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'categoriesDestroy'])->name('destroy');
            Route::post('/{id}/toggle', [AdminController::class, 'categoriesToggle'])->name('toggle');
        });

        // Analytics
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/', [AnalyticsController::class, 'index'])->name('index');
            Route::get('/chart-data', [AnalyticsController::class, 'getChartData'])->name('chart-data');
            Route::get('/impact', [AnalyticsController::class, 'impactReport'])->name('impact');
            Route::post('/custom-report', [AnalyticsController::class, 'customReport'])->name('custom-report');
            Route::post('/export', [AnalyticsController::class, 'exportReport'])->name('export');
            Route::post('/clear-cache', [AnalyticsController::class, 'clearCache'])->name('clear-cache');
            Route::get('/reports', [AnalyticsController::class, 'reports'])->name('reports');
            Route::get('/data', [AnalyticsController::class, 'getData'])->name('data');
        });

        // Posts Management
        Route::prefix('posts')->name('posts.')->group(function () {
            Route::get('/', [PostController::class, 'adminIndex'])->name('index');
            Route::get('/pending', [PostController::class, 'pending'])->name('pending');
            Route::post('/{id}/approve', [PostController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [PostController::class, 'reject'])->name('reject');
            Route::post('/{id}/pin', [PostController::class, 'togglePin'])->name('pin');
            Route::delete('/{id}/force-delete', [PostController::class, 'forceDelete'])->name('force-delete');
            Route::get('/reports', [PostController::class, 'reports'])->name('reports');
            Route::get('/reports', [PostController::class, 'reports'])->name('reports.index');
            Route::post('/reports/{id}/handle', [PostController::class, 'handleReport'])->name('reports.handle');
        });

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            // Route chính: admin.reports.index
            Route::get('/', [ReportGenerationController::class, 'index'])->name('index');
            Route::get('/', [PostController::class, 'reports'])->name('index');
            Route::post('/{id}/handle', [PostController::class, 'handleReport'])->name('handle');
            // Route tạo báo cáo (xem trước): admin.reports.generate
            Route::get('/generate', [ReportGenerationController::class, 'generate'])->name('generate');

            // Route tải xuống (PDF/CSV): admin.reports.download
            Route::get('/download/{type}', [ReportGenerationController::class, 'download'])->name('download');
        });
        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

        // Campaigns
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            // GET /admin/campaigns (Danh sách)
            Route::get('/', [DonationCampaignController::class, 'index'])->name('index');

            // GET /admin/campaigns/create (Tạo mới)
            Route::get('/create', [DonationCampaignController::class, 'create'])->name('create');

            // POST /admin/campaigns (Lưu mới)
            Route::post('/', [DonationCampaignController::class, 'store'])->name('store');

            // [ĐÃ SỬA LỖI] GET /admin/campaigns/{id}/export-donations (Export)
            Route::get('/{id}/export-donations', [DonationCampaignController::class, 'exportDonations'])->name('export-donations');

            // GET /admin/campaigns/{id}/edit (Chỉnh sửa)
            Route::get('/{id}/edit', [DonationCampaignController::class, 'edit'])->name('edit');

            // PUT /admin/campaigns/{id} (Cập nhật)
            Route::put('/{id}', [DonationCampaignController::class, 'update'])->name('update');

            // DELETE /admin/campaigns/{id} (Xóa)
            Route::delete('/{id}', [DonationCampaignController::class, 'destroy'])->name('destroy');

            // GET /admin/campaigns/{id}/donations (Xem danh sách quyên góp)
            Route::get('/{id}/donations', [DonationCampaignController::class, 'showDonations'])->name('showDonations');
        });

        // Email Management
        Route::prefix('emails')->name('emails.')->group(function () {
            Route::post('/send', [AdminEmailController::class, 'sendEmail'])->name('send');
            Route::post('/emails/send', [App\Http\Controllers\Admin\AdminController::class, 'sendEmail'])->name('emails.send');
            Route::get('/history', [AdminEmailController::class, 'history'])->name('history');
            Route::get('/templates', [AdminEmailController::class, 'getTemplates'])->name('templates');
        });
    });

/*
|--------------------------------------------------------------------------
| API Routes (AJAX Calls)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('api')->name('api.')->group(function () {

    // Video Calls API
    Route::prefix('video-calls')->name('video-calls.')->group(function () {
        Route::post('/initiate', [VideoCallController::class, 'initiate'])->name('initiate');
        Route::post('/accept', [VideoCallController::class, 'accept'])->name('accept');
        Route::post('/decline', [VideoCallController::class, 'decline'])->name('decline');
        Route::post('/end', [VideoCallController::class, 'end'])->name('end');
        Route::post('/token', [VideoCallController::class, 'token'])->name('token');
        Route::get('/{call_id}/status', [VideoCallController::class, 'status'])->name('status');
    });

    // Favorites API
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::post('/toggle', [FavoriteController::class, 'toggle'])->name('toggle');
        Route::get('/check/{opportunityId}', [FavoriteController::class, 'check'])->name('check');
        Route::get('/count', [FavoriteController::class, 'count'])->name('count');
    });

    // Messages API
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/unread-count', [MessageController::class, 'getUnreadCount'])->name('unread-count');
        Route::post('/typing', [MessageController::class, 'typing'])->name('typing');
        Route::get('/conversations/{conversationId}/search', [MessageController::class, 'search'])->name('search');
    });

    // Notifications API
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');

    // Search API
    Route::prefix('search')->name('search.')->group(function () {
        Route::get('/suggestions', [SearchController::class, 'suggestions'])->name('suggestions');
        Route::get('/popular', [SearchController::class, 'popularSearches'])->name('popular');
        Route::get('/trending', [SearchController::class, 'trendingOpportunities'])->name('trending');
    });
});

/*
|--------------------------------------------------------------------------
| Test Routes (Development Only)
|--------------------------------------------------------------------------
*/
if (config('app.debug')) {
    Route::get('/test-agora-config', function () {
        return response()->json([
            'app_id' => config('services.agora.app_id'),
            'has_certificate' => !empty(config('services.agora.certificate')),
            'certificate_length' => strlen(config('services.agora.certificate') ?? ''),
            'token_expire' => config('services.agora.token_expire'),
        ]);
    })->middleware('auth');

    Route::get('/test-agora-token', function () {
        $appId = config('services.agora.app_id');
        $appCertificate = config('services.agora.certificate');
        $channelName = 'test_' . time();
        $uid = Auth::id() ?? rand(1, 999999);
        $expireTime = 3600;
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
}

/*
|--------------------------------------------------------------------------
| Shared Routes (Accessible by multiple roles)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Applications - Both volunteer and organization
    Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');

    // Volunteer Activities
    Route::prefix('volunteer-activities')->name('volunteer-activities.')->group(function () {
        Route::get('/', [VolunteerActivityController::class, 'index'])->name('index');
        Route::get('/create', [VolunteerActivityController::class, 'create'])->name('create');
        Route::post('/', [VolunteerActivityController::class, 'store'])->name('store');
        Route::get('/{id}', [VolunteerActivityController::class, 'show'])->name('show');
        Route::post('/{id}/verify', [VolunteerActivityController::class, 'verify'])->name('verify');
        Route::get('/export', [VolunteerActivityController::class, 'export'])->name('export');
    });
});

/*
|--------------------------------------------------------------------------
| THANH TOÁN ROUTES (MOMO)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // 1. Route tạo thanh toán
    // Lưu ý: Đổi tên route thành 'donation.createMomo' để khớp với View show.blade.php
    Route::post('/donation/create', [DonationController::class, 'createPayment'])->name('donation.createPayment');

    // 2. Route Fake Gateway (Nếu dùng giả lập)
    Route::get('/payment/fake-momo', [DonationController::class, 'fakeMomoGateway'])->name('payment.fakeMomo');
});

// 3. Route Return URL (Người dùng quay về từ MoMo)
Route::get('/donation/momo', [DonationController::class, 'momoReturn'])->name('donation.momoReturn');

// 4. [QUAN TRỌNG] Route IPN - Đây là cái thiếu gây lỗi 500
Route::get('/donation/momo-ipn', [DonationController::class, 'momoIpn'])->name('donation.momoIpn');

Route::get('/api/locations/provinces', function () {
    // Lấy những bản ghi không có cha (parent_code là NULL)
    // Hoặc lọc theo level='tinh' hoặc 'thanh-pho' nếu data có parent_code null
    $provinces = VnLocation::whereNull('parent_code')
        ->select('code', 'full_name as name') // Đổi tên cột để khớp với JS cũ
        ->orderBy('name')
        ->get();

    return response()->json(['data' => $provinces]);
})->name('api.locations.provinces');

// 2. API Lấy danh sách Phường/Xã theo Mã Tỉnh
Route::get('/api/locations/wards/{provinceCode}', function ($provinceCode) {
    // Lấy tất cả con của mã tỉnh truyền vào
    $wards = VnLocation::where('parent_code', $provinceCode)
        ->select('code', 'full_name as name')
        ->orderBy('name')
        ->get();

    return response()->json(['data' => $wards]);
})->name('api.locations.wards');

// cửa hậu để mở khóa bảo trì trang web
Route::get('/emergency-unlock-maintenance', function () {

    // 1. Cập nhật Database: Set maintenance_mode = 0 (Tắt)
    \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
        ['key' => 'maintenance_mode'],
        ['value' => '0']
    );

    // 2. Xóa Cache để hệ thống nhận diện thay đổi
    \Illuminate\Support\Facades\Cache::forget('setting_maintenance_mode');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');

    return "<div style='text-align:center; padding-top:50px; font-family:sans-serif;'>
                <h1 style='color:green;'>✅ Đã tắt bảo trì thành công!</h1>
                <p>Hệ thống đã hoạt động trở lại.</p>
                <a href='/' style='text-decoration:none; background:#4F46E5; color:white; padding:10px 20px; border-radius:5px;'>Về trang chủ</a>
            </div>";
});

/*
|--------------------------------------------------------------------------
| Fallback Route (404 Page)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('errors.404');
});
