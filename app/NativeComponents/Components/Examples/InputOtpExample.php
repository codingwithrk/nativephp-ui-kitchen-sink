<?php

namespace App\NativeComponents\Components\Examples;

use App\NativeComponents\Components\ExampleScreen;

class InputOtpExample extends ExampleScreen
{
    /** Its examples show toasts, which the banner would cover. */
    protected bool $hidesBannerAd = true;

    public string $code = '';

    public string $codeWithSeparator = '';

    public string $pin = '';

    public function verify(): void
    {
        $this->toast('Code submitted', $this->code, 'success');
    }

    /**
     * @return array{isWrongPin: bool}
     */
    protected function viewData(): array
    {
        return ['isWrongPin' => strlen($this->pin) === 4 && $this->pin !== '1234'];
    }
}
