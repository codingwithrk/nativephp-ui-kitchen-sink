<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class PaginationExample extends ExampleScreen
{
    public int $page = 1;

    public int $controlledPage = 5;

    public function goToPage(int $page): void
    {
        $this->controlledPage = $page;
    }
}
