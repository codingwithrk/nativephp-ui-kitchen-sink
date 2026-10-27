<?php

namespace App\Showcase;

/**
 * A newer release of the app on this platform's store.
 */
final readonly class AppUpdate
{
    public function __construct(
        public string $platform,
        public string $installedVersion,
        public string $latestVersion,
        public string $storeUrl,
        public bool $isForced,
        public ?string $message = null,
    ) {}

    /**
     * The store's name as users know it.
     */
    public function storeName(): string
    {
        return $this->platform === 'ios' ? 'App Store' : 'Google Play';
    }
}
