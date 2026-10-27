<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class ToasterExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    public function save(): void
    {
        $this->toast('Saved', 'Your changes were saved.', 'success');
    }

    public function notify(): void
    {
        $this->toast('Event created', 'Sunday, December 3 at 9:00 AM');
    }

    public function fail(): void
    {
        $this->toast('Upload failed', 'The file is larger than 10 MB.', 'destructive');
    }
}
