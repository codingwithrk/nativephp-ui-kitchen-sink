<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class AccordionExample extends ExampleScreen
{
    public string $faq = 'shipping';

    /** @var list<string> */
    public array $openSections = ['notifications', 'privacy'];
}
