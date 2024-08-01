<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Sosmed;
use App\Models\Header;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        View::composer('layouts.footer', function ($view) {
            $view->with('sosmed', Sosmed::all());
        });

        View::composer('layouts.hero', function ($view) {
            $view->with('headers', Header::all()); // Fetch all headers or use a query to get specific data
        });
    }
}
