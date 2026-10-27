<?php

use App\NativeComponents\Components\Examples\ButtonExample;
use App\Showcase\BannerAds;
use Native\Mobile\Testing\Native;

it('shows a Google test banner on pushed screens', function () {
    Native::visit('/components/button')
        ->assertNativeCalled('GoogleMobileAds.Initialize')
        ->assertNativeCalled('GoogleMobileAds.ShowBanner', fn (array $params): bool => $params['ad_unit_id'] === 'ca-app-pub-3940256099942544/9214589741'
            && $params['position'] === 'bottom');

    expect(BannerAds::isVisible())->toBeTrue();
});

it('keeps tab screens free of banners so the tab bar stays visible', function (string $tab) {
    Native::visit($tab)->assertNativeNotCalled('GoogleMobileAds.ShowBanner');

    expect(BannerAds::isVisible())->toBeFalse();
})->with(['/', '/components', '/themes', '/templates', '/about']);

it('hides the banner when leaving a pushed screen', function () {
    $screen = Native::visit('/components/button');

    $screen->instance()->unmount();

    expect(BannerAds::isVisible())->toBeFalse();
    $screen->assertNativeCalled('GoogleMobileAds.HideBanner');
});

it('leaves room for the banner at the end of the page', function () {
    $tree = json_encode(Native::test(ButtonExample::class)->tree());

    expect(BannerAds::shouldShowOn(new ButtonExample, null))->toBeTrue()
        ->and($tree)->toContain('"height":64');
});

it('skips screens whose toasts the banner would cover', function () {
    Native::visit('/components/toaster')->assertNativeNotCalled('GoogleMobileAds.ShowBanner');
    Native::visit('/components/sidebar/demo')->assertNativeNotCalled('GoogleMobileAds.ShowBanner');
});

it('shows nothing when ads are switched off', function () {
    config(['google-mobile-ads.enabled' => false]);

    Native::visit('/components/button')
        ->assertNativeNotCalled('GoogleMobileAds.Initialize')
        ->assertNativeNotCalled('GoogleMobileAds.ShowBanner');
});

it('uses the configured ad unit outside test mode', function () {
    config([
        'google-mobile-ads.test_mode' => false,
        'google-mobile-ads.slots.anchored_adaptive_banner' => ['android' => 'ca-app-pub-1111/2222', 'ios' => 'ca-app-pub-3333/4444'],
    ]);

    expect(BannerAds::adUnitId())->toBe('ca-app-pub-1111/2222');

    config(['google-mobile-ads.slots.anchored_adaptive_banner' => null]);

    expect(BannerAds::adUnitId())->toBeNull();
});
