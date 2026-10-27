<?php

namespace App\Showcase;

/**
 * A section of the component catalog, such as Forms or Overlays.
 */
final readonly class ComponentGroup
{
    public function __construct(
        public string $slug,
        public string $label,
        public string $description,
        public PlatformIcon $icon,
        public string $color,
    ) {}

    /**
     * @param  array{label: string, description: string, icon: array{ios: string, android: string}, color: string}  $group
     */
    public static function fromArray(string $slug, array $group): self
    {
        return new self(
            slug: $slug,
            label: $group['label'],
            description: $group['description'],
            icon: PlatformIcon::fromArray($group['icon']),
            color: $group['color'],
        );
    }

    public function url(): string
    {
        return '/components/groups/'.$this->slug;
    }
}
