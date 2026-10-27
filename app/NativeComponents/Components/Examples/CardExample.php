<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class CardExample extends ExampleScreen
{
    public string $projectName = '';

    public bool $isPrivate = true;

    public bool $isDeploying = false;

    public function deploy(): void
    {
        $this->isDeploying = ! $this->isDeploying;
    }

    public function cancel(): void
    {
        $this->projectName = '';
        $this->isDeploying = false;
    }
}
