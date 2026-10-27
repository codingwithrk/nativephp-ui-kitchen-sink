<?php

namespace App\NativeComponents;

use App\Showcase\BannerAds;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Static display components: typography, buttons, badges, avatars,
 * feedback (progress, skeleton, spinner), alerts and cards.
 */
class Gallery extends NativeComponent
{
    public int $progress = 40;

    public bool $isDeploying = false;

    public int $deployCount = 0;

    public bool $isLoadingPreview = true;

    public function increaseProgress(): void
    {
        $this->progress = min(100, $this->progress + 10);
    }

    public function decreaseProgress(): void
    {
        $this->progress = max(0, $this->progress - 10);
    }

    public function toggleDeploying(): void
    {
        $this->isDeploying = ! $this->isDeploying;

        if ($this->isDeploying) {
            $this->deployCount++;
        }
    }

    public function togglePreview(): void
    {
        $this->isLoadingPreview = ! $this->isLoadingPreview;
    }

    public function render(): View
    {
        return view('native.gallery', [
            'hasBannerSpace' => BannerAds::shouldShowOn($this, null),
        ]);
    }
}
