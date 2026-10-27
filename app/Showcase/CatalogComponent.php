<?php

namespace App\Showcase;

use App\NativeComponents\Components\ExampleScreen;
use Illuminate\Support\Str;

/**
 * One nativephp-ui component in the catalog, with its example screen.
 */
final readonly class CatalogComponent
{
    /**
     * @param  list<string>  $tags  the tags available in the version being built for
     * @param  array<string, string>  $updates  version => what changed, for versions up to that one
     */
    public function __construct(
        public string $slug,
        public string $name,
        public string $group,
        public string $description,
        public array $tags,
        public string $since,
        public PlatformIcon $icon,
        public array $updates = [],
    ) {}

    /**
     * Build the entry as it is in plugin `$version`: tags and updates from
     * later versions are left out.
     *
     * @param  array{name: string, group: string, description: string, tags: list<string>, tags_since?: array<string, string>, since: string, updated?: array<string, string>, icon: array{ios: string, android: string}}  $component
     */
    public static function fromArray(string $slug, array $component, string $version): self
    {
        $tagsSince = $component['tags_since'] ?? [];

        return new self(
            slug: $slug,
            name: $component['name'],
            group: $component['group'],
            description: $component['description'],
            tags: array_values(array_filter(
                $component['tags'],
                fn (string $tag): bool => version_compare($tagsSince[$tag] ?? $component['since'], $version, '<='),
            )),
            since: $component['since'],
            icon: PlatformIcon::fromArray($component['icon']),
            updates: array_filter(
                $component['updated'] ?? [],
                fn (string $note, string $updatedIn): bool => version_compare($updatedIn, $version, '<='),
                ARRAY_FILTER_USE_BOTH,
            ),
        );
    }

    /**
     * What changed in `$version`, or null when it didn't change then.
     */
    public function updateIn(string $version): ?string
    {
        return $this->updates[$version] ?? null;
    }

    public function hasTag(string $tag): bool
    {
        return in_array($tag, $this->tags, true);
    }

    public function url(): string
    {
        return '/components/'.$this->slug;
    }

    /**
     * The example screen class, by convention: `button-group` → `ButtonGroupExample`.
     *
     * @return class-string<ExampleScreen>
     */
    public function screen(): string
    {
        return self::screenNamespace().Str::studly($this->slug).'Example';
    }

    public function view(): string
    {
        return 'native.components.examples.'.$this->slug;
    }

    public static function slugForScreen(string $screen): string
    {
        return Str::kebab(Str::beforeLast(class_basename($screen), 'Example'));
    }

    public static function screenNamespace(): string
    {
        return 'App\\NativeComponents\\Components\\Examples\\';
    }
}
