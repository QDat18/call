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
use App\Http\Controllers\Admin\OrganizationVerificationController;
use App\Http\Controllers\Admin\DonationCampaignController;
use App\Http\Controllers\DonationController;

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
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

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
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
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
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change-password.update');

    // User Deactivation
    Route::post('/user/deactivate', [UserController::class, 'deactivate'])->name('user.deactivate');

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::get('/recent', [UserController::class, 'getRecentNotifications'])->name('recent');
        Route::post('/{notification}/mark-read', [UserController::class, 'markNotificationRead'])->name('mark-read');
        Route::post('/mark-all-read', [UserController::class, 'markAllNotificationsRead'])->name('mark-all-read');
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

    // Messages
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/conversation/{conversationId}', [MessageController::class, 'index'])->name('index');
        Route::post('/conversation/{conversationId}', [MessageController::class, 'send'])->name('send');
        Route::post('/conversation/{conversationId}/read', [MessageController::class, 'markRead'])->name('read');
        Route::post('/conversation/{conversationId}/upload', [MessageController::class, 'uploadAttachment'])->name('upload');
        Route::delete('/conversation/{conversationId}/{messageId}', [MessageController::class, 'destroy'])->name('destroy');
        Route::get('/conversation/{conversationId}/latest', [MessageController::class, 'getLatest'])->name('latest');
        Route::get('/unread-count', [MessageController::class, 'getUnreadCount'])->name('unread-count');
    });

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
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/my-posts', [PostController::class, 'myPosts'])->name('my-posts');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy');

        // Post Interactions
        Route::post('/{id}/like', [PostController::class, 'toggleLike'])->name('like');
        Route::post('/{id}/comment', [PostController::class, 'addCommentFromForm'])->name('comment');
        Route::post('/{id}/share', [PostController::class, 'share'])->name('share');
        Route::post('/{id}/bookmark', [PostController::class, 'bookmark'])->name('bookmark');
        Route::post('/{id}/report', [PostController::class, 'report'])->name('report');
    });

    // Comments
    Route::post('/comments', [PostController::class, 'storeComment'])->name('comments.store');
    Route::delete('/comments/{id}', [PostController::class, 'deleteComment'])->name('comments.destroy');

    // Bookmarks
    Route::get('/bookmarks', [PostController::class, 'bookmarks'])->name('bookmarks');
    Route::put('/bookmarks/{id}/notes', [PostController::class, 'updateBookmarkNotes'])->name('bookmarks.update-notes');
});

/*
|--------------------------------------------------------------------------
| VOLUNTEER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'volunteer'])->prefix('volunteer')->name('volunteer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'volunteerDashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [VolunteerProfileController::class, 'show'])->name('profile.profile');
    Route::get('/profile/edit', [VolunteerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [VolunteerProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/skills', [VolunteerProfileController::class, 'updateSkills'])->name('profile.skills');
    Route::put('/profile/availability', [VolunteerProfileController::class, 'updateAvailability'])->name('profile.availability');

    // Applications
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/', [ApplicationController::class, 'myApplications'])->name('my');
        Route::get('/create', [ApplicationController::class, 'create'])->name('create');
        Route::post('/', [ApplicationController::class, 'store'])->name('store');
        Route::get('/{id}', [ApplicationController::class, 'show'])->name('show');
        Route::post('/{id}/withdraw', [ApplicationController::class, 'withdraw'])->name('withdraw');
    });

    // Activities
    Route::prefix('activities')->name('activities.')->group(function () {
        Route::get('/', [VolunteerActivityController::class, 'index'])->name('index');
        Route::get('/create', [VolunteerActivityController::class, 'create'])->name('create');
        Route::post('/', [VolunteerActivityController::class, 'store'])->name('store');
        Route::get('/{id}', [VolunteerActivityController::class, 'show'])->name('show');
        Route::post('/{id}/dispute', [VolunteerActivityController::class, 'dispute'])->name('dispute');
        Route::get('/export', [VolunteerActivityController::class, 'export'])->name('export');
    });

    // Favorites
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('index');
        Route::post('/toggle', [FavoriteController::class, 'toggle'])->name('toggle');
        Route::put('/{id}/notes', [FavoriteController::class, 'updateNotes'])->name('notes');
        Route::delete('/{id}', [FavoriteController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-destroy', [FavoriteController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::get('/export', [FavoriteController::class, 'export'])->name('export');
    });

    // xac thuc TOP
    Route::post('/profile/send-verification-otp', [VolunteerProfileController::class, 'sendVerificationOtp'])
        ->name('profile.sendOtp');
    Route::get('/profile/verify-otp', [VolunteerProfileController::class, 'showOtpForm'])
        ->name('profile.showOtp');
    Route::post('/profile/verify-otp', [VolunteerProfileController::class, 'verifyOtp'])
        ->name('profile.verifyOtp');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
});

/*
|--------------------------------------------------------------------------
| ORGANIZATION ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('organization')->name('organization.')->group(function () {

    // Profile
    Route::get('/profile', [OrganizationController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [OrganizationController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [OrganizationController::class, 'update'])->name('profile.update');

    // Opportunities
    Route::prefix('opportunities')->name('opportunities.')->group(function () {
        Route::get('/', [VolunteerOpportunityController::class, 'organizationIndex'])->name('index');
        Route::get('/create', [VolunteerOpportunityController::class, 'create'])->name('create');
        Route::post('/', [VolunteerOpportunityController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [VolunteerOpportunityController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VolunteerOpportunityController::class, 'update'])->name('update');
        Route::delete('/{id}', [VolunteerOpportunityController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/pause', [VolunteerOpportunityController::class, 'pause'])->name('pause');
        Route::post('/{id}/resume', [VolunteerOpportunityController::class, 'resume'])->name('resume');
    });

    // Applications
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/', [ApplicationController::class, 'organizationIndex'])->name('index');
        Route::put('/{id}/review', [ApplicationController::class, 'review'])->name('review');
    });

    // Volunteers
    Route::get('/volunteers', [OrganizationController::class, 'volunteers'])->name('volunteers.index');

    // Activities
    Route::prefix('activities')->name('activities.')->group(function () {
        Route::get('/', [VolunteerActivityController::class, 'organizationIndex'])->name('index');
        Route::post('/{id}/verify', [VolunteerActivityController::class, 'verify'])->name('verify');
    });

    // Analytics
    Route::get('/analytics', [OrganizationAnalyticsController::class, 'index'])->name('analytics');
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
            Route::get('/{id}', [AdminController::class, 'showUser'])->name('show');
            Route::get('/{id}/edit', [AdminController::class, 'editUser'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateUser'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('destroy');
            Route::post('/{id}/activate', [AdminController::class, 'activateUser'])->name('activate');
            Route::post('/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('deactivate');
            Route::get('/export', [AdminController::class, 'exportUsers'])->name('export');
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
            Route::get('/export', [AdminController::class, 'exportOrganizations'])->name('export');
        });

        // Opportunities
        Route::prefix('opportunities')->name('opportunities.')->group(function () {
            Route::get('/', [AdminController::class, 'opportunities'])->name('index');
            Route::get('/{id}', [AdminController::class, 'showOpportunity'])->name('show');
            Route::delete('/{id}', [AdminController::class, 'deleteOpportunity'])->name('destroy');
            Route::get('/export', [AdminController::class, 'exportOpportunities'])->name('export');
        });

        // Applications
        Route::prefix('applications')->name('applications.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminController::class, 'showApplication'])->name('show');
            Route::get('/export', [AdminController::class, 'exportApplications'])->name('export');
        });

        // Activities
        Route::prefix('activities')->name('activities.')->group(function () {
            Route::get('/', [AdminController::class, 'activities'])->name('index');
            Route::get('/{id}', [AdminController::class, 'showActivity'])->name('show');
            Route::get('/disputes', [AdminController::class, 'disputedActivities'])->name('disputes');
            Route::post('/{id}/resolve-dispute', [AdminController::class, 'resolveDispute'])->name('resolve-dispute');
        });

        // Reviews
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'pending'])->name('index');
            Route::get('/all', [AdminController::class, 'allReviews'])->name('all');
            Route::get('/pending', [ReviewController::class, 'pending'])->name('pending');
            Route::post('/{id}/approve', [ReviewController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [ReviewController::class, 'reject'])->name('reject');
            Route::post('/bulk-approve', [ReviewController::class, 'bulkApprove'])->name('bulk-approve');
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
        });

        // Reports
        Route::post('/reports/{id}/resolve', [PostController::class, 'resolveReport'])->name('reports.resolve');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

        // Campaigns
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('/', [DonationCampaignController::class, 'index'])->name('index');
            Route::get('/create', [DonationCampaignController::class, 'create'])->name('create');
            Route::post('/', [DonationCampaignController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DonationCampaignController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DonationCampaignController::class, 'update'])->name('update');
            Route::delete('/{id}', [DonationCampaignController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/donations', [DonationCampaignController::class, 'showDonations'])->name('showDonations');
        });

        // Email Management
        Route::prefix('emails')->name('emails.')->group(function () {
            Route::post('/send', [AdminEmailController::class, 'sendEmail'])->name('send');
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
| THANH TOÁN ROUTES (VNPAY)
|--------------------------------------------------------------------------
*/
// Bắt buộc login để tạo thanh toán
Route::middleware('auth')->post('/donation/create', [DonationController::class, 'createPayment'])->name('donation.createPayment');
// Các route VNPay gọi về, không cần login
Route::get('/donation/vnpay-return', [DonationController::class, 'vnpayReturn'])->name('donation.vnpayReturn');
Route::get('/donation/vnpay-ipn', [DonationController::class, 'vnpayIpn'])->name('donation.vnpayIpn');

/*
|--------------------------------------------------------------------------
| Fallback Route (404 Page)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('errors.404');
});
