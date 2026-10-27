<?php

use App\NativeComponents\Home;
use App\NativeComponents\UpdateRequired;
use App\Showcase\AppUpdates;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Testing\Native;

const UpdateUrl = 'https://api.example.com/app-version';
const PlayStoreUrl = 'https://play.google.com/store/apps/details?id=com.codingwithrk.nativephpui';
const AppStoreUrl = 'https://apps.apple.com/app/id123456789';

beforeEach(function () {
    config(['showcase.updates.url' => UpdateUrl, 'nativephp.version' => '1.0.0']);

    // One fake for the whole test that answers with whatever fakeRelease()
    // last set, so a test can change the API's answer part-way through.
    Http::fake([UpdateUrl.'*' => fn () => Http::response(...$GLOBALS['fakeReleaseResponse'])]);
});

/**
 * Set what the update API returns: Android and iOS entries layered over a
 * 1.2.0 optional release, and the HTTP status.
 */
function fakeRelease(array $android = [], array $ios = [], int $status = 200): void
{
    $GLOBALS['fakeReleaseResponse'] = [[
        'android' => [...['version' => '1.2.0', 'force_update' => false, 'store_url' => PlayStoreUrl, 'message' => null], ...$android],
        'ios' => [...['version' => '1.2.0', 'force_update' => false, 'store_url' => AppStoreUrl, 'message' => null], ...$ios],
    ], $status];
}

it('does nothing without an update URL', function () {
    config(['showcase.updates.url' => null]);
    fakeRelease();

    Native::test(Home::class)->assertSet('isUpdateDialogOpen', false);

    Http::assertNothingSent();
});

it('asks for the platform and installed version', function () {
    fakeRelease();

    AppUpdates::check();

    Http::assertSent(fn (Request $request): bool => $request['platform'] === 'android' && $request['version'] === '1.0.0');
});

it('offers an optional update that opens the Play Store', function () {
    fakeRelease();

    Native::test(Home::class)
        ->assertSet('isUpdateDialogOpen', true)
        ->assertSee('Version 1.2.0 is available on Google Play')
        ->tap('update-now')
        ->assertNativeCalled('Browser.Open', fn (array $params): bool => $params['url'] === PlayStoreUrl)
        ->assertSet('isUpdateDialogOpen', false);
});

it('uses the App Store entry on iOS', function () {
    Native::fakeBridge()->respondTo('Device.GetInfo', ['info' => json_encode(['platform' => 'ios'])]);
    fakeRelease(ios: ['version' => '1.3.0']);

    $update = AppUpdates::check();

    expect($update->platform)->toBe('ios')
        ->and($update->latestVersion)->toBe('1.3.0')
        ->and($update->storeUrl)->toBe(AppStoreUrl)
        ->and($update->storeName())->toBe('App Store');
});

it('asks again next launch after "Not now"', function () {
    fakeRelease();

    Native::test(Home::class)->tap('update-later')->assertSet('isUpdateDialogOpen', false);
    Native::test(Home::class)->assertSet('isUpdateDialogOpen', true);
});

it('stays quiet about a skipped version until a newer one ships', function () {
    fakeRelease();

    Native::test(Home::class)->tap('update-skip')->assertSet('isUpdateDialogOpen', false);
    Native::test(Home::class)->assertSet('isUpdateDialogOpen', false);

    fakeRelease(android: ['version' => '1.3.0']);
    AppUpdates::check(fresh: true);

    Native::test(Home::class)->assertSet('isUpdateDialogOpen', true);
});

it('shows a custom message from the API', function () {
    fakeRelease(android: ['message' => 'Big redesign! Update now.']);

    Native::test(Home::class)->assertSee('Big redesign! Update now.');
});

it('sends a forced update to the blocking update screen', function () {
    fakeRelease(android: ['force_update' => true]);

    Native::test(Home::class)
        ->assertReplacedWith('/update')
        ->assertSet('isUpdateDialogOpen', false);
});

it('cannot skip a forced update', function () {
    fakeRelease(android: ['force_update' => true]);
    $update = AppUpdates::check();

    AppUpdates::skip($update);

    expect(AppUpdates::shouldPrompt($update))->toBeTrue();
});

it('blocks the app until the forced update is installed', function () {
    fakeRelease(android: ['force_update' => true]);

    Native::test(UpdateRequired::class)
        ->assertSee('Update required')
        ->assertSee('v1.0.0')
        ->assertSee('v1.2.0')
        ->tap('update-now')
        ->assertNativeCalled('Browser.Open', fn (array $params): bool => $params['url'] === PlayStoreUrl)
        ->pressBack()
        ->assertNoNavigation();
});

it('lets the user back in once the update is no longer required', function () {
    fakeRelease(android: ['force_update' => true]);
    $screen = Native::test(UpdateRequired::class);

    fakeRelease(android: ['version' => '1.0.0', 'force_update' => true]);

    $screen->tap('check-again')
        ->assertSet('isStillRequired', false)
        ->assertReplacedWith('/');
});

it('ignores releases that are not newer or not valid', function (array $android) {
    fakeRelease(android: $android);

    expect(AppUpdates::check())->toBeNull();
})->with([
    'same version' => [['version' => '1.0.0']],
    'older version' => [['version' => '0.9.0']],
    'not a version' => [['version' => 'latest']],
    'insecure store link' => [['store_url' => 'http://play.google.com/store']],
]);

it('treats a failed request as no update and tries again later', function () {
    fakeRelease(status: 500);

    expect(AppUpdates::check())->toBeNull();

    fakeRelease();

    expect(AppUpdates::check())->not->toBeNull();
});

it('skips the update check while the device is offline', function () {
    Native::fakeBridge()->withOffline();
    fakeRelease();

    Native::test(Home::class)->assertSet('isUpdateDialogOpen', false);

    Http::assertNothingSent();
});

it('checks again once the device is back online', function () {
    $bridge = Native::fakeBridge()->withOffline();
    fakeRelease();

    expect(AppUpdates::check())->toBeNull();

    $bridge->withWifi();

    expect(AppUpdates::check())->not->toBeNull();
    Http::assertSentCount(1);
});

it('still enforces a cached forced update while offline', function () {
    $bridge = Native::fakeBridge()->withWifi();
    fakeRelease(android: ['force_update' => true]);
    AppUpdates::check();

    $bridge->withOffline();

    Native::test(Home::class)->assertReplacedWith('/update');
    Http::assertSentCount(1);
});

it('treats an unknown network status as online', function () {
    Native::fakeBridge()->withError('Network unavailable');
    fakeRelease();

    expect(AppUpdates::check())->not->toBeNull();
});

it('accepts the single-platform response the API gives for ?platform=', function () {
    $GLOBALS['fakeReleaseResponse'] = [['version' => '1.2.0', 'force_update' => true, 'store_url' => PlayStoreUrl, 'message' => null], 200];

    $update = AppUpdates::check();

    expect($update->latestVersion)->toBe('1.2.0')
        ->and($update->isForced)->toBeTrue()
        ->and($update->storeUrl)->toBe(PlayStoreUrl);
});
