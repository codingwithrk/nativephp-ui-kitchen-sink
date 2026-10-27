<?php

use App\Icons\Android;
use App\Icons\AndroidOutlined;
use App\Icons\Ios;
use App\NativeComponents\About;
use App\NativeComponents\Components\ComponentBrowser;
use App\NativeComponents\Components\SidebarDemo;
use App\NativeComponents\Home;
use App\NativeComponents\Templates\TemplateBrowser;
use App\NativeComponents\Themes;
use App\NativeComponents\UpdateRequired;
use App\Showcase\Catalog;
use Codingwithrk\NativephpUi\Ui;
use Native\Mobile\Testing\Native;

/**
 * Icon names iOS can't draw: not an SF Symbol (dotted path or a name in
 * the generated Ios enum), not in NativePHP's IconHelper.swift map, and
 * not one nativephp-ui translates itself.
 *
 * @param  array<string, mixed>  $tree
 * @return list<string>
 */
function unrenderableIosIcons(array $tree): array
{
    static $known = null;

    if ($known === null) {
        $helper = file_get_contents(base_path('vendor/nativephp/mobile/resources/xcode/NativePHP/NativeUI/IconHelper.swift'));
        preg_match_all('/case ((?:"[^"]+",?\s*)+):/', $helper, $cases);
        preg_match_all('/"([^"]+)"/', implode(' ', $cases[1]), $names);
        $known = array_map('strtolower', [...$names[1], ...array_values(Ui::IOS_ICONS)]);
    }

    $unrenderable = [];
    $walk = function (array $node) use (&$walk, &$unrenderable, $known): void {
        $name = $node['props']['name'] ?? null;

        if (($node['type'] ?? null) === 'icon' && is_string($name) && ! str_contains($name, '.')
            && Ios::tryFrom($name) === null && ! in_array(strtolower($name), $known, true)) {
            $unrenderable[] = $name;
        }

        foreach ($node['children'] ?? [] as $child) {
            $walk($child);
        }
    };
    $walk($tree);

    return array_values(array_unique($unrenderable));
}

it('draws every icon on iOS', function () {
    $screens = [
        Home::class,
        ComponentBrowser::class,
        Themes::class,
        TemplateBrowser::class,
        SidebarDemo::class,
        About::class,
        UpdateRequired::class,
        ...collect(Catalog::installedComponents())->map->screen()->all(),
        ...collect(Catalog::templates())->pluck('screen')->all(),
    ];

    $failures = collect($screens)
        ->mapWithKeys(fn (string $screen): array => [$screen => unrenderableIosIcons(Native::test($screen, platform: 'ios')->tree())])
        ->filter();

    foreach (Catalog::groups() as $group) {
        $missing = unrenderableIosIcons(Native::visit($group->url(), platform: 'ios')->tree());

        if ($missing !== []) {
            $failures[$group->url()] = $missing;
        }
    }

    expect($failures->all())->toBe([]);
})->skip(fn () => ! defined(Ui::class.'::IOS_ICONS'), 'Needs codingwithrk/nativephp-ui 1.1.0');

/**
 * Icon names Android can't draw: not a Material icon (filled or outlined).
 *
 * @param  array<string, mixed>  $tree
 * @return list<string>
 */
function unrenderableAndroidIcons(array $tree): array
{
    $unrenderable = [];
    $walk = function (array $node) use (&$walk, &$unrenderable): void {
        $name = $node['props']['name'] ?? null;

        if (($node['type'] ?? null) === 'icon' && is_string($name)
            && Android::tryFrom($name) === null && AndroidOutlined::tryFrom($name) === null) {
            $unrenderable[] = $name;
        }

        foreach ($node['children'] ?? [] as $child) {
            $walk($child);
        }
    };
    $walk($tree);

    return array_values(array_unique($unrenderable));
}

it('draws every icon on Android', function () {
    $screens = [
        Home::class,
        ComponentBrowser::class,
        Themes::class,
        TemplateBrowser::class,
        SidebarDemo::class,
        About::class,
        UpdateRequired::class,
        ...collect(Catalog::installedComponents())->map->screen()->all(),
        ...collect(Catalog::templates())->pluck('screen')->all(),
    ];

    $failures = collect($screens)
        ->mapWithKeys(fn (string $screen): array => [$screen => unrenderableAndroidIcons(Native::test($screen, platform: 'android')->tree())])
        ->filter();

    foreach (Catalog::groups() as $group) {
        $missing = unrenderableAndroidIcons(Native::visit($group->url(), platform: 'android')->tree());

        if ($missing !== []) {
            $failures[$group->url()] = $missing;
        }
    }

    expect($failures->all())->toBe([]);
});
