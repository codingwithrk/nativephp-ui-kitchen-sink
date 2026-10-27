<?php

namespace App\Showcase;

/**
 * An icon as an SF Symbol for iOS and a Material icon for Android.
 */
final readonly class PlatformIcon
{
    public function __construct(
        public string $ios,
        public string $android,
    ) {}

    /**
     * @param  array{ios: string, android: string}  $icon
     */
    public static function fromArray(array $icon): self
    {
        return new self($icon['ios'], $icon['android']);
    }
}
