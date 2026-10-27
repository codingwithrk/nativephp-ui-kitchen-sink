<?php

namespace App\NativeComponents;

use App\Showcase\AppUpdates;
use App\Showcase\Catalog;
use App\Showcase\CatalogComponent;
use App\Showcase\Concerns\PicksDocsVersion;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Browser;

/**
 * The Home tab — the documentation site's landing page: hero with a live
 * example, features, a gallery of live component previews, theming and
 * templates, for the docs version being viewed.
 */
class Home extends NativeComponent
{
    use PicksDocsVersion;

    /**
     * The site's feature grid.
     *
     * @var list<array{title: string, text: string, ios: string, android: string}>
     */
    private const array Features = [
        ['title' => 'Truly native', 'text' => 'Tags compile to EDGE elements and render as SwiftUI and Jetpack Compose views. No web view, no HTML.', 'ios' => 'iphone', 'android' => 'smartphone'],
        ['title' => "shadcn's design system", 'text' => 'The same tokens, spacing and radii. Five base colors, seven accents and a configurable radius.', 'ios' => 'paintbrush', 'android' => 'brush'],
        ['title' => 'Automatic dark mode', 'text' => 'Every token ships with a light and a dark value. You never write a dark: class.', 'ios' => 'moon', 'android' => 'dark_mode'],
        ['title' => 'Two-way binding', 'text' => 'native:model on switches, tabs, radio groups, accordions and dialogs, with updated…() hooks included.', 'ios' => 'link', 'android' => 'link'],
        ['title' => 'Still just EDGE', 'text' => 'Your classes win, unknown attributes are forwarded, and every prop can be dynamic.', 'ios' => 'curlybraces', 'android' => 'data_object'],
        ['title' => 'Pure PHP', 'text' => 'No Kotlin, no Swift, no native rebuilds. Update with Composer and keep shipping.', 'ios' => 'bolt', 'android' => 'bolt'],
    ];

    public string $projectName = '';

    public bool $isPrivate = true;

    public bool $isDeploying = false;

    public bool $isWifiOn = true;

    public bool $isBluetoothOn = false;

    public string $range = 'week';

    /** @var list<string> */
    public array $styles = ['bold'];

    public string $plan = 'pro';

    public string $fruit = 'banana';

    public string $code = '42';

    public bool $isUpdateDialogOpen = false;

    public string $updateVersion = '';

    public string $updateStoreUrl = '';

    public string $updateStoreName = '';

    public ?string $updateMessage = null;

    /**
     * Check for a new release when the app opens: a forced update replaces
     * the app with the update screen; an optional one asks in a dialog.
     */
    public function mount(): void
    {
        $update = AppUpdates::check();

        if ($update === null || ! AppUpdates::shouldPrompt($update)) {
            return;
        }

        if ($update->isForced) {
            $this->replace('/update');

            return;
        }

        $this->updateVersion = $update->latestVersion;
        $this->updateStoreUrl = $update->storeUrl;
        $this->updateStoreName = $update->storeName();
        $this->updateMessage = $update->message;
        $this->isUpdateDialogOpen = true;
    }

    public function updateNow(): void
    {
        $this->isUpdateDialogOpen = false;

        if ($this->updateStoreUrl !== '') {
            Browser::open($this->updateStoreUrl);
        }
    }

    /**
     * Close the dialog for now; it asks again next time the app opens.
     */
    public function remindLater(): void
    {
        $this->isUpdateDialogOpen = false;
    }

    /**
     * Don't ask about this version again.
     */
    public function skipUpdate(): void
    {
        $update = AppUpdates::check();

        if ($update !== null) {
            AppUpdates::skip($update);
        }

        $this->isUpdateDialogOpen = false;
    }

    public function deploy(): void
    {
        $this->isDeploying = ! $this->isDeploying;
    }

    public function cancel(): void
    {
        $this->projectName = '';
        $this->isDeploying = false;
    }

    /**
     * Open the NativePHP UI page on the CodingwithRK Marketplace in the
     * in-app browser — the same link as the About tab's "Get a license".
     */
    public function openMarketplace(): void
    {
        $url = config('showcase.about.links.license.url');

        if (is_string($url)) {
            Browser::inApp($url);
        }
    }

    public function render(): View
    {
        $components = Catalog::components();

        return view('native.home', [
            'features' => self::Features,
            'componentCount' => count($components),
            'tagCount' => Catalog::tagCount(),
            'groupCount' => count(Catalog::groups()),
            'hasV110Gallery' => version_compare(Catalog::viewingVersion(), '1.1.0', '>='),
            'galleryBadges' => collect($components)
                ->mapWithKeys(fn (CatalogComponent $component): array => [$component->slug => Catalog::badgeFor($component)])
                ->all(),
            'templates' => Catalog::templates(),
            'upcomingCount' => Catalog::upcomingCount(),
            'latestVersion' => Catalog::latestVersion(),
            ...$this->versionPickerData(),
        ]);
    }
}
