<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Sosmed;
use App\Models\Header;
use App\Models\Footer;

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
            $view->with('footer_desc', Footer::where('category', 'footer_desc')->get());
        });

        View::composer('layouts.footer', function ($view) {
            $view->with('sosmed', Sosmed::all());
        });

        View::composer('layouts.footer', function ($view) {
            $view->with('branch', Footer::where('category', 'branch')->get());
        });

        View::composer('layouts.footer', function ($view) {
            $view->with('contact_footer', Footer::where('category', 'contact')->get());
        });

        View::composer('layouts.hero', function ($view) {
            $view->with('headers', Header::all()); // Fetch all headers or use a query to get specific data
        });
    }
}
