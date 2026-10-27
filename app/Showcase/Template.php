<?php

namespace App\Showcase;

use Native\Mobile\Edge\NativeComponent;

/**
 * A complete example screen built from many components.
 */
final readonly class Template
{
    /**
     * @param  class-string<NativeComponent>  $screen
     */
    public function __construct(
        public string $slug,
        public string $name,
        public string $category,
        public string $description,
        public PlatformIcon $icon,
        public string $screen,
    ) {}

    /**
     * @param  array{name: string, category: string, description: string, icon: array{ios: string, android: string}, screen: class-string<NativeComponent>}  $template
     */
    public static function fromArray(string $slug, array $template): self
    {
        return new self(
            slug: $slug,
            name: $template['name'],
            category: $template['category'],
            description: $template['description'],
            icon: PlatformIcon::fromArray($template['icon']),
            screen: $template['screen'],
        );
    }

    public function url(): string
    {
        return '/templates/'.$this->slug;
    }
}
