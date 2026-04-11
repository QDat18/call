<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Organization;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.tailwind');
        Paginator::defaultSimpleView('vendor.pagination.simple-tailwind');
        View::composer('admin.*', function ($view) {
            if (auth()->check() && auth()->user()->user_type === 'Admin') {
                $pendingVerifications = Organization::where('verification_status', 'Pending')->count();
                $view->with('pendingVerifications', $pendingVerifications);
            }
        });
        Relation::morphMap([
            'post' => \App\Models\Post::class,
            // 'user' => \App\Models\User::class, // Thêm dòng này nếu sau này có report User
            // 'comment' => \App\Models\Comment::class, // Thêm dòng này nếu sau này có report Comment
        ]);

if (!app()->runningInConsole()) {
        if (Schema::hasTable('settings')) {
            // 1. Chia sẻ biến 'site_name' cho TẤT CẢ các View
            View::share('site_name', get_setting('site_name', 'VolunteerConnect'));
            View::share('site_description', get_setting('site_description'));
            View::share('contact_email', get_setting('contact_email'));

            // 2. Cấu hình Mail động theo Database
            Config::set('mail.from.address', get_setting('mail_from_address', env('MAIL_FROM_ADDRESS')));
            Config::set('mail.from.name', get_setting('mail_from_name', env('MAIL_FROM_NAME')));
        }
    }
    }
}
