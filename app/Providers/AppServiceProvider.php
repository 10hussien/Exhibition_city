<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\CompanyObserver;
use App\Models\CompanyInformation;


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
        CompanyInformation::observe(CompanyObserver::class);
    }
}
