<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class SwitchExample extends ExampleScreen
{
    public bool $isAirplaneMode = false;

    public bool $wantsMarketingEmails = false;

    public bool $wantsSecurityEmails = true;

    public bool $isWifiEnabled = true;

    public bool $isCompactMode = true;

    public function setWifi(bool $isEnabled): void
    {
        $this->isWifiEnabled = $isEnabled;
    }
}
