<?php

use App\NativeComponents\Themes;
use App\Showcase\ThemeSettings;
use Codingwithrk\NativephpUi\Ui;
use Illuminate\Support\Facades\File;
use Native\Mobile\Testing\Native;
use Native\Mobile\UI\Theme;
use PHPUnit\Framework\AssertionFailedError;

it('applies and saves a new accent', function () {
    Native::test(Themes::class)
        ->tap('accent-blue')
        ->assertSet('accent', 'blue');

    expect(ThemeSettings::load()->accent)->toBe('blue')
        ->and(Theme::get('light.ui-primary'))->toBe('#155DFC')
        ->and(Theme::get('light.primary'))->toBe('#155DFC');
});

it('changes the base color', function () {
    Native::test(Themes::class)
        ->tap('base-stone')
        ->assertSet('baseColor', 'stone');

    expect(ThemeSettings::load()->baseColor)->toBe('stone');
});

it('forces dark mode by giving both modes the dark palette', function () {
    Native::test(Themes::class)
        ->tap('appearance-dark')
        ->assertSet('appearance', 'dark');

    expect(Theme::get('light.ui-background'))->toBe(Theme::get('dark.ui-background'))
        ->and(ThemeSettings::load()->appearance)->toBe('dark');
});

it('changes the radius used by every component', function () {
    Native::test(Themes::class)
        ->tap('radius-16')
        ->assertSet('radius', 16);

    expect(config('nativephp-ui.radius'))->toBe(16)
        ->and(Ui::radius('lg'))->toBe('rounded-[16]')
        ->and(Ui::component('chip'))->not->toBeNull();
});

it('resets to the default theme', function () {
    (new ThemeSettings(appearance: 'dark', baseColor: 'stone', accent: 'rose', radius: 0))->save();

    Native::test(Themes::class)
        ->assertSet('baseColor', 'stone')
        ->tap('reset-theme')
        ->assertSet('baseColor', 'zinc')
        ->assertSet('accent', 'violet')
        ->assertSet('appearance', 'system');

    expect(ThemeSettings::hasSaved())->toBeFalse();
});

it('cannot reset when the theme is already the default', function () {
    $screen = Native::test(Themes::class);

    expect(fn () => $screen->tap('reset-theme'))->toThrow(AssertionFailedError::class);
});

it('ignores a corrupt or invalid saved theme', function () {
    File::ensureDirectoryExists(dirname(ThemeSettings::path()));
    File::put(ThemeSettings::path(), '{"baseColor":"purple","radius":3}');

    expect(ThemeSettings::load()->baseColor)->toBe('zinc')
        ->and(ThemeSettings::load()->radius)->toBe(10);
});

it('drives the showcase preview', function () {
    Native::test(Themes::class)
        ->assertSee('Release 2.4.0')
        ->tap('pause')
        ->assertSet('isConfirmingPause', true)
        ->tap('preview-settings')
        ->assertSee('Automatic updates');
});
