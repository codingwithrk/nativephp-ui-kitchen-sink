<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class MessageExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    public string $draft = '';

    /** @var list<array{id: int, role: string, initials: string, text: string}> */
    public array $messages = [
        ['id' => 1, 'role' => 'assistant', 'initials' => 'AI', 'text' => 'Hi! How can I help you today?'],
        ['id' => 2, 'role' => 'user', 'initials' => 'RK', 'text' => 'Show me what NativePHP UI can do.'],
        ['id' => 3, 'role' => 'assistant', 'initials' => 'AI', 'text' => 'Every bubble here is a native view. Try sending a message.'],
    ];

    public function send(): void
    {
        if (blank($this->draft)) {
            return;
        }

        $nextId = count($this->messages) + 1;

        $this->messages[] = ['id' => $nextId, 'role' => 'user', 'initials' => 'RK', 'text' => $this->draft];
        $this->messages[] = ['id' => $nextId + 1, 'role' => 'assistant', 'initials' => 'AI', 'text' => 'You said: '.$this->draft];
        $this->draft = '';
    }
}
