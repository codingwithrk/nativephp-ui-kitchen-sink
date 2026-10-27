<?php

namespace App\Showcase;

use Native\Mobile\Edge\ChromeContributorRegistry;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\System;
use NativePHP\GoogleMobileAds\GoogleMobileAdsServiceProvider;
use WeakMap;

/**
 * Google AdMob banners on pushed screens (component pages, templates,
 * group lists). Tab screens get no banner: it is pinned to the bottom safe
 * area and would cover the tab bar.
 *
 * Calls the bhargavdetroja/nativephp-google-mobile-ads bridge functions
 * directly: that plugin's PHP facade only mirrors its JS API and never
 * reaches the device. Its config (enabled, test_mode, slots, test_slots)
 * still decides whether ads run and which ad unit to use.
 *
 * A screen opts out with `protected bool $hidesBannerAd = true;`.
 */
final class BannerAds
{
    /** Whether a banner is currently on screen. */
    private static bool $isVisible = false;

    private static bool $isInitialized = false;

    /** @var WeakMap<NativeComponent, true>|null screens already holding the banner */
    private static ?WeakMap $holders = null;

    /**
     * Hook into every screen render. Returns no chrome: it only shows or
     * hides the native banner when the screen on view changes.
     */
    public static function register(): void
    {
        ChromeContributorRegistry::register(function (NativeComponent $screen, ?NativeLayout $layout): null {
            self::syncFor($screen, $layout);

            return null;
        });
    }

    public static function syncFor(NativeComponent $screen, ?NativeLayout $layout): void
    {
        if (! self::shouldShowOn($screen, $layout)) {
            self::hide();

            return;
        }

        self::show();

        self::$holders ??= new WeakMap;

        if (! isset(self::$holders[$screen])) {
            self::$holders[$screen] = true;
            $screen->registerCleanup(fn () => self::hide());
        }
    }

    public static function shouldShowOn(NativeComponent $screen, ?NativeLayout $layout): bool
    {
        if (! self::isEnabled() || $layout !== null) {
            return false;
        }

        $hides = (fn (): bool => (bool) ($this->hidesBannerAd ?? false))->call($screen);

        return ! $hides;
    }

    public static function isEnabled(): bool
    {
        return (bool) config('google-mobile-ads.enabled', false)
            && class_exists(GoogleMobileAdsServiceProvider::class);
    }

    public static function isTestMode(): bool
    {
        return (bool) config('google-mobile-ads.test_mode', true);
    }

    public static function isVisible(): bool
    {
        return self::$isVisible;
    }

    /**
     * The ad unit for a slot on this platform: Google's demo unit in test
     * mode, otherwise the slot's configured ID.
     */
    public static function adUnitId(?string $slot = null): ?string
    {
        $slot ??= (string) config('showcase.ads.banner_slot', 'banner');
        $platform = self::platform();

        $id = self::isTestMode()
            ? config("google-mobile-ads.test_slots.{$slot}.{$platform}")
            : config("google-mobile-ads.slots.{$slot}");

        if (is_array($id)) {
            $id = $id[$platform] ?? null;
        }

        return is_string($id) && $id !== '' ? $id : null;
    }

    public static function show(): void
    {
        if (self::$isVisible || ($adUnitId = self::adUnitId()) === null) {
            return;
        }

        if (! self::$isInitialized) {
            self::call('GoogleMobileAds.Initialize');
            self::$isInitialized = true;
        }

        self::call('GoogleMobileAds.ShowBanner', [
            'ad_unit_id' => $adUnitId,
            'position' => 'bottom',
            'size' => 'adaptive',
        ]);

        self::$isVisible = true;
    }

    public static function hide(): void
    {
        if (! self::$isVisible) {
            return;
        }

        self::call('GoogleMobileAds.HideBanner');

        self::$isVisible = false;
    }

    /** Forget all state — for tests. */
    public static function reset(): void
    {
        self::$isVisible = false;
        self::$isInitialized = false;
        self::$holders = null;
    }

    private static function platform(): string
    {
        return System::isIos() ? 'ios' : 'android';
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    private static function call(string $method, array $parameters = []): void
    {
        if (function_exists('nativephp_call')) {
            nativephp_call($method, json_encode((object) $parameters));
        }
    }
}
