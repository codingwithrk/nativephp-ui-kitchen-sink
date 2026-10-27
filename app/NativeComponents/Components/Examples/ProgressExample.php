<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;
use Native\Mobile\Attributes\Poll;

class ProgressExample extends ExampleScreen
{
    public int $percent = 13;

    /**
     * Advances the simulated upload, wrapping back to zero when it completes.
     */
    #[Poll(700)]
    public function advance(): void
    {
        $this->percent = $this->percent >= 100 ? 0 : min(100, $this->percent + 9);
    }
}
