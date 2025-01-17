<?php

namespace App\Providers;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use App\Observers\CategoryObserver; 

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
        Category::observe(CategoryObserver::class);
    }
}
