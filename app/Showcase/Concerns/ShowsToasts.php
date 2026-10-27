<?php

namespace App\Showcase\Concerns;

use Illuminate\Support\Str;
use Native\Mobile\Edge\CallbackRegistry;

/**
 * Toasts and sheet-menu helpers with the same contract as nativephp-ui
 * 1.1.0's `InteractsWithUi` trait (`$uiToasts`, `toast()`,
 * `dismissToast()`, `uiRun()`), which `<ui:toaster>` and
 * `<ui:context-menu>` call into.
 *
 * The app keeps its own copy so every screen class still loads on plugin
 * versions that don't ship the trait yet — NativePHP autoloads every class
 * under app/NativeComponents at boot.
 */
trait ShowsToasts
{
    /** @var list<array{id: string, title: string, description: ?string, variant: string, expires: int}> */
    public array $uiToasts = [];

    /**
     * Show a toast. `$variant`: default, success, destructive. `$duration`
     * is in milliseconds; 0 keeps it until dismissed.
     */
    public function toast(string $title, ?string $description = null, string $variant = 'default', int $duration = 4000): void
    {
        $now = (int) floor(microtime(true) * 1000);

        $this->uiToasts = array_values(array_filter(
            $this->uiToasts,
            fn (array $toast): bool => $toast['expires'] === 0 || $toast['expires'] > $now,
        ));

        $this->uiToasts[] = [
            'id' => (string) Str::ulid(),
            'title' => $title,
            'description' => $description,
            'variant' => $variant,
            'expires' => $duration > 0 ? $now + $duration : 0,
        ];

        $this->uiToasts = array_slice($this->uiToasts, -3);
    }

    public function dismissToast(string $id): void
    {
        $this->uiToasts = array_values(array_filter($this->uiToasts, fn (array $toast): bool => $toast['id'] !== $id));
    }

    /**
     * Close the sheet `$property` controls, then run `$handler`.
     */
    public function uiRun(string $property, string $handler): mixed
    {
        $this->__syncProperty($property, false);

        $parsed = CallbackRegistry::parse($handler);

        return $this->__invokeInteraction($parsed['method'], $parsed['args']);
    }
}
