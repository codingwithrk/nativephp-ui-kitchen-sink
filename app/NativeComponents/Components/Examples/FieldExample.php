<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class FieldExample extends ExampleScreen
{
    public string $email = 'rk@';

    public string $bio = '';

    /**
     * @return array{emailError: ?string}
     */
    protected function viewData(): array
    {
        return [
            'emailError' => filter_var($this->email, FILTER_VALIDATE_EMAIL) ? null : 'Please enter a valid email address.',
        ];
    }
}
