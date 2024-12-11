<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

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
       // phpinfo();
        Gate::define('isStudent', function ($user, $student) {
            return  $student->user_id == auth()->id();
        });
        Model::preventLazyLoading();
    }
}
