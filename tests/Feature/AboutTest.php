<?php

use App\NativeComponents\About;
use App\NativeComponents\Home;
use Native\Mobile\Testing\Native;

it('shows the app, its version and build', function () {
    config(['nativephp.version' => '2.3.4', 'nativephp.version_code' => 56]);

    Native::test(About::class)
        ->assertSee('Version 2.3.4')
        ->assertSee('nativephp-ui v1.1.0')
        ->assertSee('52 components');
});

it('credits the libraries it is built on with their licenses', function () {
    $credits = collect((new About)->credits())->keyBy('key');

    expect($credits['codingwithrk/nativephp-ui']['license'])->toBe('proprietary')
        ->and($credits['laravel/framework']['license'])->toBe('MIT')
        ->and($credits['material-icons']['license'])->toBe('Apache-2.0')
        ->and($credits['laravel/framework']['version'])->not->toStartWith('v')
        ->and($credits['nativephp/mobile-network']['name'])->toBe('NativePHP Network');

    Native::test(About::class)
        ->assertSee('Licenses')
        ->assertSee('NativePHP Mobile UI')
        ->assertSee('shadcn/ui');
});

it('opens links in the in-app browser', function () {
    Native::test(About::class)
        ->tap('link-docs')
        ->assertNativeCalled('Browser.OpenInApp', fn (array $params): bool => $params['url'] === 'https://nativephp-ui.codingwithrk.com')
        ->tap('credit-shadcn/ui')
        ->assertNativeCalled('Browser.OpenInApp', fn (array $params): bool => $params['url'] === 'https://ui.shadcn.com');
});

it('says whether ads are on', function () {
    Native::test(About::class)->assertSee('This app shows Google AdMob banners');

    config(['google-mobile-ads.enabled' => false]);

    Native::test(About::class)->assertSee('Ads are turned off');
});

it('opens the marketplace from the home call to action', function () {
    Native::test(Home::class)
        ->tap('open-marketplace')
        ->assertNativeCalled('Browser.OpenInApp', fn (array $params): bool => $params['url'] === 'https://marketplace.codingwithrk.com/products/nativephp-ui');
});
