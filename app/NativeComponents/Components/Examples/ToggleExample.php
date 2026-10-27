<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class ToggleExample extends ExampleScreen
{
    public bool $isBold = true;

    public bool $isItalic = false;

    public bool $isUnderlined = false;

    public bool $isStarred = false;

    public function setStarred(bool $isStarred): void
    {
        $this->isStarred = $isStarred;
    }
}
