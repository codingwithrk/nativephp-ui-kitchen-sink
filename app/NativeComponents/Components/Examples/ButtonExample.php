<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;
use Native\Mobile\Attributes\Poll;

class ButtonExample extends ExampleScreen
{
    public bool $isSaving = false;

    public float $savingStartedAt = 0;

    public function save(): void
    {
        $this->isSaving = true;
        $this->savingStartedAt = microtime(true);
    }

    /**
     * Finishes the simulated save about two seconds after it started.
     */
    #[Poll(500)]
    public function finishSaving(): void
    {
        if ($this->isSaving && microtime(true) - $this->savingStartedAt >= 1.8) {
            $this->isSaving = false;
        }
    }
}
