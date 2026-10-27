<?php

use App\Icons\Android;
use App\Icons\Ios;
use App\NativeComponents\Components\ComponentBrowser;
use App\NativeComponents\Home;
use App\NativeComponents\Templates\TemplateBrowser;
use App\Showcase\Catalog;
use App\Showcase\CatalogComponent;
use App\Showcase\DocsVersion;
use Native\Mobile\Testing\Native;

it('has a screen class and a view for every registered component', function () {
    foreach (config('showcase.components') as $slug => $entry) {
        $component = CatalogComponent::fromArray($slug, $entry, Catalog::latestVersion());

        expect(class_exists($component->screen()))->toBeTrue("Missing {$component->screen()}")
            ->and(view()->exists($component->view()))->toBeTrue("Missing view {$component->view()}")
            ->and(config("showcase.groups.{$component->group}"))->not->toBeNull("Unknown group for [{$slug}]");
    }
});

it('uses icon names that exist on both platforms', function () {
    $icons = collect(config('showcase.groups'))->pluck('icon')
        ->merge(collect(config('showcase.components'))->pluck('icon'))
        ->merge(collect(config('showcase.templates'))->pluck('icon'));

    $icons->each(function (array $icon) {
        expect(Ios::tryFrom($icon['ios']))->not->toBeNull("Unknown SF Symbol [{$icon['ios']}]")
            ->and(Android::tryFrom($icon['android']))->not->toBeNull("Unknown Material icon [{$icon['android']}]");
    });
});

it('only shows components the installed plugin version provides', function () {
    config(['showcase.plugin_version' => '1.0.1']);

    expect(Catalog::components())->toHaveCount(26)
        ->and(Catalog::hasComponent('select'))->toBeFalse()
        ->and(Catalog::newComponents())->toBe([])
        ->and(Catalog::component('dialog')->hasTag('dialog-trigger'))->toBeFalse()
        ->and(Catalog::upcomingCount())->toBe(26);

    config(['showcase.plugin_version' => '1.1.0']);

    expect(Catalog::components())->toHaveCount(52)
        ->and(Catalog::newComponents())->toHaveCount(26)
        ->and(Catalog::component('dialog')->hasTag('dialog-trigger'))->toBeTrue()
        ->and(Catalog::groups())->toHaveCount(11)
        ->and(Catalog::upcomingCount())->toBe(0);
});

it('hides groups that have no components in the installed version', function () {
    config(['showcase.plugin_version' => '1.0.1']);

    expect(collect(Catalog::groups())->pluck('slug'))->not->toContain('selection', 'data', 'navigation', 'chat');
});

it('renders the home screen like the docs landing page', function () {
    Native::test(Home::class)
        ->assertSee('shadcn/ui, rendered')
        ->assertSee('Everything you like about shadcn. On a phone. For real.')
        ->assertSee(count(Catalog::components()).' components. '.Catalog::tagCount().' tags.')
        ->assertSee('One config file. Every shadcn theme.')
        ->assertSee('Dashboard');
});

it('keeps the home gallery previews live', function () {
    Native::test(Home::class)
        ->tap('bluetooth')->assertSet('isBluetoothOn', true)
        ->tap('range-month')->assertSet('range', 'month')
        ->input('project-name', 'Acme')
        ->tap('cancel')->assertSet('projectName', '');
});

it('tells 1.0.1 users how many components an update unlocks', function () {
    config(['showcase.plugin_version' => '1.0.1']);

    Native::test(Home::class)
        ->assertSee('26 more components in 1.1.0')
        ->assertSee('forms, lists, tabs, dialogs, feedback and more')
        ->assertDontSee('Input OTP');
});

it('switches the docs version from the version picker', function () {
    Native::test(ComponentBrowser::class)
        ->assertSee('v1.1.0')
        ->tap('version-picker')
        ->assertSet('isVersionSheetOpen', true)
        ->tap('version-1.0.0')
        ->assertSet('viewedVersion', '1.0.0')
        ->assertSet('isVersionSheetOpen', false)
        ->assertSee('v1.0.0')
        ->assertDontSee('Selection');

    expect(Catalog::viewingVersion())->toBe('1.0.0')
        ->and(Catalog::components())->toHaveCount(26)
        ->and(Catalog::installedComponents())->toHaveCount(52);
});

it('badges new and updated components for the version being viewed', function () {
    expect(Catalog::badgeFor(Catalog::component('select')))->toBe('New')
        ->and(Catalog::badgeFor(Catalog::component('dialog')))->toBe('Updated')
        ->and(Catalog::badgeFor(Catalog::component('card')))->toBeNull();

    DocsVersion::view('1.0.1');

    expect(Catalog::badgeFor(Catalog::component('dialog')))->toBeNull()
        ->and(Catalog::component('dialog')->hasTag('dialog-trigger'))->toBeFalse();
});

it('never views a version newer than the installed plugin', function () {
    config(['showcase.plugin_version' => '1.0.1']);

    DocsVersion::view('1.1.0');

    expect(Catalog::viewingVersion())->toBe('1.0.1')
        ->and(collect(DocsVersion::options())->pluck('version')->all())->toBe(['1.0.1', '1.0.0']);
});

it('lists groups and filters components by name, description or tag', function () {
    Native::test(ComponentBrowser::class)
        ->assertSee('Forms')
        ->assertSee('Overlays')
        ->input('search', 'sheet')
        ->assertSee('Dialog, Sheet & Drawer')
        ->assertDontSee('Typography')
        ->tap('clear-search')
        ->assertSet('search', '')
        ->assertSee('Layout');
});

it('shows an empty state when no component matches', function () {
    Native::test(ComponentBrowser::class)
        ->input('search', 'zzz')
        ->assertSee('No components found');
});

it('lists the components of a group', function () {
    Native::visit('/components/groups/forms')
        ->assertSee('Inputs, fields and controls bound with native:model.')
        ->assertSee('Field')
        ->assertSee('Radio Group')
        ->assertDontSee('Accordion');
});

it('lists templates by category', function () {
    Native::test(TemplateBrowser::class)
        ->assertSee('Analytics')
        ->assertSee('Sign up')
        ->assertSee('Projects');
});
