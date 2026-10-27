<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class CheckboxExample extends ExampleScreen
{
    public bool $hasAcceptedTerms = false;

    public bool $wantsNewsletter = true;

    public bool $hasAgreedToPolicy = false;
}
