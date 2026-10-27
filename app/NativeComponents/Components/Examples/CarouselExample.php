<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class CarouselExample extends ExampleScreen
{
    /**
     * @return array{slides: list<array{title: string, text: string}>}
     */
    protected function viewData(): array
    {
        return [
            'slides' => [
                ['title' => 'Native first', 'text' => 'Every tag renders as SwiftUI or Jetpack Compose.'],
                ['title' => 'Themeable', 'text' => 'Base colors, accents, radius and dark mode.'],
                ['title' => 'Bindable', 'text' => 'native:model works like it does on native inputs.'],
                ['title' => 'Testable', 'text' => 'Drive every screen with Native::test().'],
            ],
        ];
    }
}
