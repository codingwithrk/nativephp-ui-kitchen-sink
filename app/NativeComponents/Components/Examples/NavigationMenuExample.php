<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class NavigationMenuExample extends ExampleScreen
{
    public string $section = 'home';

    public function setSection(string $section): void
    {
        $this->section = $section;
    }
}
