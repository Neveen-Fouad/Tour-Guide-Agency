<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use App\Models\Request;
use App\Models\Review;
use App\Models\Tourist;
use App\Policies\ReviewPolicy;
use App\Policies\TouristPolicy;
use App\Policies\TourRequestPolicy;

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
        Gate::policy(Request::class, TourRequestPolicy::class);
        Gate::policy(Review::class, ReviewPolicy::class);
        Gate::policy(Tourist::class, TouristPolicy::class);

        ResetPassword::createUrlUsing(function(object $user,string $token){
            return config('app.frontend_url').'Html%20files/resetPassword.html?token='.$token.'&email='.urlencode($user->email);
    });
    }
}
