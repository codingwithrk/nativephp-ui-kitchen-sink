<?php

namespace App\Providers;

use Codingwithrk\NativephpUi\NativephpUiServiceProvider;
use Codingwithrk\PackageInfo\PackageInfoServiceProvider;
use Illuminate\Support\ServiceProvider;
use Native\Mobile\Providers\BrowserServiceProvider;
use Native\Mobile\Providers\NetworkServiceProvider;
use Native\Mobile\UI\NativeUIServiceProvider;
use NativePHP\GoogleMobileAds\GoogleMobileAdsServiceProvider;

class NativeServiceProvider extends ServiceProvider
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
    }

    /**
     * The NativePHP plugins to enable.
     *
     * Only plugins listed here will be compiled into your native builds.
     * This is a security measure to prevent transitive dependencies from
     * automatically registering plugins without your explicit consent.
     *
     * @return array<int, class-string<ServiceProvider>>
     */
    public function plugins(): array
    {
        return [
            NativephpUiServiceProvider::class,
            NativeUIServiceProvider::class,
            PackageInfoServiceProvider::class,
            BrowserServiceProvider::class,
            GoogleMobileAdsServiceProvider::class,
            NetworkServiceProvider::class,
        ];
    }
}
