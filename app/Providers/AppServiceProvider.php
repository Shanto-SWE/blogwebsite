<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Catregory;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    
    {
        $categories = Catregory::take(4)->get();
        View::share('categories', $categories);

        $setting = Setting::first();
        View::share('setting', $setting);
    }
}
