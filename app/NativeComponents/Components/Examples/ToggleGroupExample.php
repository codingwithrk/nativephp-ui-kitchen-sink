<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class ToggleGroupExample extends ExampleScreen
{
    public string $alignment = 'left';

    /** @var list<string> */
    public array $styles = ['bold'];

    public string $range = 'week';
}
