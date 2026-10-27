<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class InputGroupExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    public string $query = '';

    public string $domain = '';

    public string $draft = '';

    public string $notes = '';

    public function send(): void
    {
        if (blank($this->draft)) {
            return;
        }

        $this->toast('Message sent', $this->draft, 'success');
        $this->draft = '';
    }
}
