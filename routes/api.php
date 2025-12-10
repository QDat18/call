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
use App\Http\Controllers\ConnectionController; // NEW: Connections/Friends

use App\Models\Province;
use App\Models\Ward;
use App\Models\VnLocation;
/*
|--------------------------------------------------------------------------
| Public Routes (Không cần đăng nhập)
|--------------------------------------------------------------------------
*/

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

// Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

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

Route::prefix('search')->name('api.search.')->group(function () {
    
    // Search suggestions API
    Route::get('/suggestions', [SearchController::class, 'suggestions'])->name('suggestions');
    
    // Quick search API
    Route::get('/quick', [SearchController::class, 'quickSearch'])->name('quick');
    
    // Filter opportunities API
    Route::get('/filter', [SearchController::class, 'filterOpportunities'])->name('filter');
    
    // Location-based search API
    Route::get('/nearby', [SearchController::class, 'searchByLocation'])->name('nearby');
    
    // Search statistics API
    Route::get('/statistics', [SearchController::class, 'searchStatistics'])->name('statistics');
    
    // Trending opportunities API
    Route::get('/trending', [SearchController::class, 'trendingOpportunities'])->name('trending');
    
    // Popular searches API
    Route::get('/popular', [SearchController::class, 'popularSearches'])->name('popular');
    
    // Save search query (for analytics)
    Route::post('/save', [SearchController::class, 'saveSearch'])->name('save');
});

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

    // Dashboard - Route to appropriate dashboard based on user type
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.edit-profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [UserController::class, 'updateAvatar'])->name('update-avatar');

    // Password Change
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change-password.update');


    Route::middleware('auth:web')->group(function () {

        // ============================================
        // CONNECTIONS API
        // ============================================
        Route::prefix('connections')->group(function () {
            Route::get('/search', [ConnectionController::class, 'searchUsers']);
            Route::post('/send-request', [ConnectionController::class, 'sendRequest']);
            Route::post('/{id}/accept', [ConnectionController::class, 'acceptRequest']);
            Route::post('/{id}/decline', [ConnectionController::class, 'declineRequest']);
            Route::delete('/{id}/remove', [ConnectionController::class, 'removeFriend']);
            Route::post('/{id}/block', [ConnectionController::class, 'blockUser']);
            Route::post('/{id}/unblock', [ConnectionController::class, 'unblockUser']);
            Route::get('/{userId}/status', [ConnectionController::class, 'getConnectionStatus']);
        });

        // ============================================
        // VIDEO CALLS API
        // ============================================
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/call/token', [VideoCallController::class, 'token'])->name('call.token');
            Route::post('/call/accept', [VideoCallController::class, 'accept']);
            Route::post('/call/decline', [VideoCallController::class, 'decline']);
            Route::post('/call/end', [VideoCallController::class, 'end']);
        });
    });
    /*
    |--------------------------------------------------------------------------
    | CONVERSATIONS & MESSAGING
    |--------------------------------------------------------------------------
    */
    Route::prefix('conversations')->name('conversations.')->group(function () {
        Route::get('/', [ConversationController::class, 'index'])->name('index');
        Route::post('/', [ConversationController::class, 'store'])->name('store');
        Route::get('/{id}', [ConversationController::class, 'show'])->name('show');
        Route::delete('/{id}', [ConversationController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/archive', [ConversationController::class, 'archive'])->name('archive');
        Route::post('/{id}/unarchive', [ConversationController::class, 'unarchive'])->name('unarchive');

        // NEW: Start conversation with a friend
        Route::get('/user/{userId}', [ConversationController::class, 'getOrCreateWithUser'])->name('with-user');
    });

    // Messages
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::post('/send', [MessageController::class, 'store']);
        Route::post('/mark-read/{conversationId}', [MessageController::class, 'markAsRead']);
        Route::get('/conversation/{conversationId}', [MessageController::class, 'index'])->name('index');
        Route::post('/', [MessageController::class, 'store'])->name('store');
        Route::delete('/{id}', [MessageController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/edit', [MessageController::class, 'update'])->name('update');
        Route::post('/mark-read/{conversationId}', [MessageController::class, 'markAsRead'])->name('mark-read');
    });



    // Favorites
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('index');
        Route::post('/{opportunityId}', [FavoriteController::class, 'store'])->name('store');
        Route::delete('/{id}', [FavoriteController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/notes', [FavoriteController::class, 'updateNotes'])->name('update-notes');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('clear-all');
    });
});

/*
|--------------------------------------------------------------------------
| Volunteer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Volunteer'])->prefix('volunteer')->name('volunteer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'volunteerDashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [VolunteerProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [VolunteerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [VolunteerProfileController::class, 'update'])->name('profile.update');

    // Applications
    Route::get('/applications', [ApplicationController::class, 'volunteerApplications'])->name('applications.index');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/create/{opportunityId}', [ApplicationController::class, 'create'])->name('applications.create');
    Route::put('/applications/{id}/withdraw', [ApplicationController::class, 'withdraw'])->name('applications.withdraw');

    // Activities
    Route::get('/activities', [VolunteerActivityController::class, 'volunteerActivities'])->name('activities.index');
    Route::get('/activities/create', [VolunteerActivityController::class, 'create'])->name('activities.create');
    Route::post('/activities', [VolunteerActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{id}', [VolunteerActivityController::class, 'show'])->name('activities.show');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'volunteerAnalytics'])->name('analytics.index');
    Route::get('/analytics/impact-report', [AnalyticsController::class, 'volunteerImpactReport'])->name('analytics.impact-report');
    Route::get('/analytics/certificate/{activityId}', [AnalyticsController::class, 'generateCertificate'])->name('analytics.certificate');
});

/*
|--------------------------------------------------------------------------
| Organization Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Organization'])->prefix('organization')->name('organization.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'organizationDashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [OrganizationController::class, 'profile'])->name('profile.show');
    Route::get('/profile/edit', [OrganizationController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [OrganizationController::class, 'updateProfile'])->name('profile.update');

    // Opportunities Management
    Route::prefix('opportunities')->name('opportunities.')->group(function () {
        Route::get('/', [VolunteerOpportunityController::class, 'organizationOpportunities'])->name('index');
        Route::get('/create', [VolunteerOpportunityController::class, 'create'])->name('create');
        Route::post('/', [VolunteerOpportunityController::class, 'store'])->name('store');
        Route::get('/{id}', [VolunteerOpportunityController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [VolunteerOpportunityController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VolunteerOpportunityController::class, 'update'])->name('update');
        Route::delete('/{id}', [VolunteerOpportunityController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/pause', [VolunteerOpportunityController::class, 'pause'])->name('pause');
        Route::post('/{id}/activate', [VolunteerOpportunityController::class, 'activate'])->name('activate');
        Route::post('/{id}/complete', [VolunteerOpportunityController::class, 'complete'])->name('complete');
        Route::post('/{id}/duplicate', [VolunteerOpportunityController::class, 'duplicate'])->name('duplicate');
    });

    // Applications Management
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/', [ApplicationController::class, 'organizationApplications'])->name('index');
        Route::get('/{id}', [ApplicationController::class, 'show'])->name('show');
        Route::post('/{id}/review', [ApplicationController::class, 'review'])->name('review');
        Route::post('/{id}/accept', [ApplicationController::class, 'accept'])->name('accept');
        Route::post('/{id}/reject', [ApplicationController::class, 'reject'])->name('reject');
        Route::post('/{id}/notes', [ApplicationController::class, 'updateNotes'])->name('update-notes');
        Route::post('/{id}/schedule-interview', [ApplicationController::class, 'scheduleInterview'])->name('schedule-interview');
    });

    // Volunteers Management
    Route::prefix('volunteers')->name('volunteers.')->group(function () {
        Route::get('/', [OrganizationController::class, 'volunteers'])->name('index');
        Route::get('/{id}', [OrganizationController::class, 'showVolunteer'])->name('show');
        Route::post('/{id}/send-message', [OrganizationController::class, 'sendMessageToVolunteer'])->name('send-message');
    });

    // Activities Verification
    Route::prefix('activities')->name('activities.')->group(function () {
        Route::get('/', [VolunteerActivityController::class, 'organizationActivities'])->name('index');
        Route::get('/{id}', [VolunteerActivityController::class, 'show'])->name('show');
        Route::post('/{id}/verify', [VolunteerActivityController::class, 'verify'])->name('verify');
        Route::post('/{id}/dispute', [VolunteerActivityController::class, 'dispute'])->name('dispute');
    });

    // Analytics
    Route::get('/analytics', [OrganizationAnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/impact', [OrganizationAnalyticsController::class, 'impactReport'])->name('analytics.impact');
    Route::get('/analytics/volunteers', [OrganizationAnalyticsController::class, 'volunteersReport'])->name('analytics.volunteers');
    Route::get('/analytics/export', [OrganizationAnalyticsController::class, 'exportReport'])->name('analytics.export');

    // Posts (Organization can create posts)
    Route::get('/posts', [PostController::class, 'organizationPosts'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
});

/*
|--------------------------------------------------------------------------
| Reviews Routes (Both Volunteer and Organization)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('reviews')->name('reviews.')->group(function () {
    Route::post('/', [ReviewController::class, 'store'])->name('store');
    Route::get('/create/{opportunityId}', [ReviewController::class, 'create'])->name('create');
    Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
    Route::put('/{id}', [ReviewController::class, 'update'])->name('update');
    Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/helpful', [ReviewController::class, 'markHelpful'])->name('mark-helpful');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Organizations Management
    Route::get('/organizations', [AdminController::class, 'organizations'])->name('organizations.index');
    Route::get('/organizations/verification', [AdminController::class, 'organizationVerification'])->name('organizations.verification');
    Route::get('/organizations/{id}', [AdminController::class, 'showOrganization'])->name('organizations.show');
    Route::get('/organizations/export', [AdminController::class, 'exportOrganizations'])->name('organizations.export');

    // Opportunities Management
    Route::get('/opportunities', [AdminController::class, 'opportunities'])->name('opportunities.index');
    Route::get('/opportunities/{id}', [AdminController::class, 'showOpportunity'])->name('opportunities.show');
    Route::get('/opportunities/export', [AdminController::class, 'exportOpportunities'])->name('opportunities.export');

    // Applications Monitoring
    Route::get('/applications', [AdminController::class, 'index'])->name('applications.index');
    Route::get('/applications-export', [AdminController::class, 'exportApplications'])->name('applications.export');
    Route::get('/applications/{id}', [AdminController::class, 'showApplication'])->name('applications.show');

    // Activities Monitoring
    Route::get('/activities', [AdminController::class, 'activities'])->name('activities.index');
    Route::get('/activities/{id}', [AdminController::class, 'showActivity'])->name('activities.show');
    Route::get('/activities/disputes', [AdminController::class, 'disputedActivities'])->name('activities.disputes');
    Route::post('/activities/{id}/resolve-dispute', [AdminController::class, 'resolveDispute'])->name('activities.resolve-dispute');

    // Reviews Management
    Route::get('/reviews', [ReviewController::class, 'pending'])->name('reviews.index');
    Route::get('/reviews/all', [AdminController::class, 'allReviews'])->name('reviews.all');
    Route::get('/reviews/pending', [ReviewController::class, 'pending'])->name('reviews.pending');
    Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::post('/reviews/bulk-approve', [ReviewController::class, 'bulkApprove'])->name('reviews.bulk-approve');

    // Categories Management
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

    // Analytics & Reports
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/chart-data', [AnalyticsController::class, 'getChartData'])->name('analytics.chart-data');
    Route::get('/analytics/impact', [AnalyticsController::class, 'impactReport'])->name('analytics.impact');
    Route::post('/analytics/custom-report', [AnalyticsController::class, 'customReport'])->name('analytics.custom-report');
    Route::post('/analytics/export', [AnalyticsController::class, 'exportReport'])->name('analytics.export');
    Route::post('/analytics/clear-cache', [AnalyticsController::class, 'clearCache'])->name('analytics.clear-cache');

    // Reports
    Route::get('/analytics/reports', [AnalyticsController::class, 'reports'])->name('analytics.reports');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    Route::prefix('emails')->name('emails.')->group(function () {
        Route::post('/send', [AdminEmailController::class, 'sendEmail'])->name('send');
        Route::get('/history', [AdminEmailController::class, 'history'])->name('history');
        Route::get('/templates', [AdminEmailController::class, 'getTemplates'])->name('templates');
    });

    // Organization Verification Routes
    Route::post('/organizations/{id}/approve', [AdminController::class, 'approveOrganization'])->name('organizations.approve');
    Route::post('/organizations/{id}/reject', [AdminController::class, 'rejectOrganization'])->name('organizations.reject');

    // User Management Routes
    Route::post('/users/{id}/activate', [AdminController::class, 'activateUser'])->name('users.activate');
    Route::post('/users/{id}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');

    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');

    Route::get('/posts', [PostController::class, 'adminIndex'])->name('posts.index');
    Route::get('/posts/pending', [PostController::class, 'pending'])->name('posts.pending');
    Route::post('/posts/{id}/approve', [PostController::class, 'approve'])->name('posts.approve');
    Route::post('/posts/{id}/reject', [PostController::class, 'reject'])->name('posts.reject');
    Route::post('/posts/{id}/pin', [PostController::class, 'togglePin'])->name('posts.pin');
    Route::delete('/posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('posts.force-delete');

    // Reports management
    Route::get('/posts/reports', [PostController::class, 'reports'])->name('posts.reports');
    Route::post('/reports/{id}/resolve', [PostController::class, 'resolveReport'])->name('reports.resolve');

    // System Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});

/*
|--------------------------------------------------------------------------
| Shared Routes (Applications - both volunteer and organization can access)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');
    Route::post('/posts/{id}/bookmark', [PostController::class, 'bookmark'])->name('posts.bookmark');
    Route::get('/bookmarks', [PostController::class, 'bookmarks'])->name('posts.bookmarks');
    Route::put('/bookmarks/{id}/notes', [PostController::class, 'updateBookmarkNotes'])->name('bookmarks.update-notes');
});

/*
|--------------------------------------------------------------------------
| Shared Routes (Activities - both volunteer and organization can access)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
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

    Route::prefix('connections')->group(function () {
        Route::get('/search', [ConnectionController::class, 'searchUsers']);
        Route::post('/send-request', [ConnectionController::class, 'sendRequest']);
        Route::post('/{id}/accept', [ConnectionController::class, 'acceptRequest']);
        Route::post('/{id}/decline', [ConnectionController::class, 'declineRequest']);
        Route::delete('/{id}/remove', [ConnectionController::class, 'removeFriend']);
        Route::post('/{id}/block', [ConnectionController::class, 'blockUser']);
        Route::post('/{id}/unblock', [ConnectionController::class, 'unblockUser']);
        Route::get('/{userId}/status', [ConnectionController::class, 'getConnectionStatus']);
    });

    // Favorites API
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites/check/{opportunityId}', [FavoriteController::class, 'check'])->name('favorites.check');
    Route::get('/favorites/count', [FavoriteController::class, 'count'])->name('favorites.count');

    // Messages API
    Route::post('/messages/send', [MessageController::class, 'store'])->name('messages.send');
    Route::get('/messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('messages.unread-count');
    Route::post('/messages/typing', [MessageController::class, 'typing'])->name('messages.typing');
    Route::get('/conversations/{conversationId}/messages/search', [MessageController::class, 'search'])->name('messages.search');

    // Notifications API
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');

    // Search API
    Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');
    Route::get('/search/popular', [SearchController::class, 'popularSearches'])->name('search.popular');
    Route::get('/search/trending', [SearchController::class, 'trendingOpportunities'])->name('search.trending');

    // Video Calls API
    //Route::get('/video-calls/stats', [VideoCallController::class, 'stats'])->name('video-calls.stats');
});

/*
|--------------------------------------------------------------------------
| Fallback Route (404 Page)
|--------------------------------------------------------------------------
*/



Route::fallback(function () {
    return view('errors.404');
});
