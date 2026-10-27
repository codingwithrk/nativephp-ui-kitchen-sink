<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class CommandExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    public bool $isPaletteOpen = false;

    public string $lastCommand = '';

    public function runCommand(string $command): void
    {
        $this->lastCommand = $command;
        $this->isPaletteOpen = false;
        $this->toast('Command: '.$command);
    }

    public function openPalette(): void
    {
        $this->isPaletteOpen = true;
    }

    /**
     * @return array{commands: list<array<string, mixed>>}
     */
    protected function viewData(): array
    {
        return [
            'commands' => [
                ['value' => 'calendar', 'label' => 'Calendar', 'icon' => 'calendar_today', 'group' => 'Suggestions'],
                ['value' => 'search', 'label' => 'Search', 'icon' => 'search', 'group' => 'Suggestions'],
                ['value' => 'calculator', 'label' => 'Calculator', 'icon' => 'calculate', 'group' => 'Suggestions', 'disabled' => true],
                ['value' => 'profile', 'label' => 'Profile', 'icon' => 'person', 'group' => 'Settings', 'shortcut' => '⌘P'],
                ['value' => 'billing', 'label' => 'Billing', 'icon' => 'credit_card', 'group' => 'Settings', 'shortcut' => '⌘B'],
                ['value' => 'settings', 'label' => 'Settings', 'icon' => 'settings', 'group' => 'Settings', 'shortcut' => '⌘S'],
            ],
        ];
    }
}
