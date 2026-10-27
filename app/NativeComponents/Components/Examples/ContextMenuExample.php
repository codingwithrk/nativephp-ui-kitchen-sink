<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class ContextMenuExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    public bool $isMessageMenuOpen = false;
}
