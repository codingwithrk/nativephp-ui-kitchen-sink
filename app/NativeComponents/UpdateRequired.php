<?php

namespace App\NativeComponents;

use App\Showcase\AppUpdates;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Browser;

/**
 * The blocking screen shown when the update API marks this platform's
 * release as a forced update. It has no way back into the app: the only
 * ways out are updating from the store, or a fresh check finding that the
 * update is no longer required.
 */
class UpdateRequired extends NativeComponent
{
    /** A full-screen gate — no banner over its button. */
    protected bool $hidesBannerAd = true;

    public string $installedVersion = '';

    public string $latestVersion = '';

    public string $storeUrl = '';

    public string $storeName = 'the store';

    public ?string $message = null;

    public bool $isStillRequired = true;

    public function mount(): void
    {
        $this->load(fresh: false);
    }

    public function openStore(): void
    {
        if ($this->storeUrl !== '') {
            Browser::open($this->storeUrl);
        }
    }

    /**
     * Re-check with the API, and let the user in once no update is forced.
     */
    public function checkAgain(): void
    {
        $this->load(fresh: true);

        if (! $this->isStillRequired) {
            $this->replace('/');
        }
    }

    /**
     * The Android back button can't leave this screen.
     */
    public function onBackPressed(): void
    {
        //
    }

    private function load(bool $fresh): void
    {
        $update = AppUpdates::check($fresh);

        $this->isStillRequired = $update !== null && $update->isForced;
        $this->installedVersion = $update->installedVersion ?? AppUpdates::installedVersion();
        $this->latestVersion = $update->latestVersion ?? '';
        $this->storeUrl = $update->storeUrl ?? '';
        $this->storeName = $update?->storeName() ?? 'the store';
        $this->message = $update?->message;
    }

    public function render(): View
    {
        return view('native.update-required');
    }
}
