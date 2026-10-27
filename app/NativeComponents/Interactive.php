<?php

namespace App\NativeComponents;

use App\Showcase\BannerAds;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Selection components: tabs, toggle, toggle group (single + multiple),
 * accordion (single + multiple) and a controlled switch.
 */
class Interactive extends NativeComponent
{
    public string $tab = 'overview';

    public bool $isBold = false;

    public bool $isItalic = false;

    public string $alignment = 'left';

    /** @var list<string> */
    public array $textStyles = ['underline'];

    public string $faq = 'shipping';

    /** @var list<string> */
    public array $openSections = [];

    public bool $isWifiEnabled = true;

    public function setWifi(bool $isEnabled): void
    {
        $this->isWifiEnabled = $isEnabled;
    }

    public function render(): View
    {
        return view('native.interactive', [
            'hasBannerSpace' => BannerAds::shouldShowOn($this, null),
        ]);
    }
}
