<?php

namespace App\Providers;

use App\Showcase\BannerAds;
use App\Showcase\ThemeSettings;
use App\Ui\ShowcaseTags;
use Illuminate\Support\ServiceProvider;

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
        ShowcaseTags::register();
        BannerAds::register();

        ThemeSettings::load()->apply();
    }
}
