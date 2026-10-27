<?php

namespace App\Showcase;

use Composer\InstalledVersions;
use InvalidArgumentException;

/**
 * Read access to the showcase registry in `config/showcase.php`, filtered
 * to the plugin version being viewed (see DocsVersion), which is never
 * newer than the installed one.
 */
final class Catalog
{
    public const string PluginPackage = 'codingwithrk/nativephp-ui';

    /**
     * The newest plugin version the registry documents.
     */
    public static function latestVersion(): string
    {
        return (string) config('showcase.version');
    }

    /**
     * The installed plugin version, as `x.y.z`. A dev install (a path
     * repository or a branch) is treated as the newest documented version.
     */
    public static function installedVersion(): string
    {
        $override = config('showcase.plugin_version');

        if (is_string($override) && $override !== '') {
            return $override;
        }

        $version = InstalledVersions::isInstalled(self::PluginPackage)
            ? (string) InstalledVersions::getPrettyVersion(self::PluginPackage)
            : '';

        $version = ltrim($version, 'vV');

        return preg_match('/^\d+\.\d+\.\d+$/', $version) === 1 ? $version : self::latestVersion();
    }

    /**
     * The version the catalog is showing.
     */
    public static function viewingVersion(): string
    {
        return DocsVersion::current();
    }

    /**
     * Whether the installed plugin is at least `$version`.
     */
    public static function supports(string $version): bool
    {
        return version_compare(self::installedVersion(), $version, '>=');
    }

    /**
     * @return list<ComponentGroup>
     */
    public static function groups(): array
    {
        return collect(config('showcase.groups', []))
            ->map(fn (array $group, string $slug): ComponentGroup => ComponentGroup::fromArray($slug, $group))
            ->filter(fn (ComponentGroup $group): bool => self::componentsIn($group->slug) !== [])
            ->values()
            ->all();
    }

    public static function group(string $slug): ComponentGroup
    {
        $group = config("showcase.groups.{$slug}") ?? throw new InvalidArgumentException("Unknown showcase group [{$slug}].");

        return ComponentGroup::fromArray($slug, $group);
    }

    /**
     * Components available in the version being viewed, or in `$version`.
     *
     * @return list<CatalogComponent>
     */
    public static function components(?string $version = null): array
    {
        $version ??= self::viewingVersion();

        return collect(config('showcase.components', []))
            ->filter(fn (array $component): bool => version_compare($component['since'], $version, '<='))
            ->map(fn (array $component, string $slug): CatalogComponent => CatalogComponent::fromArray($slug, $component, $version))
            ->values()
            ->all();
    }

    public static function component(string $slug): CatalogComponent
    {
        $component = config("showcase.components.{$slug}") ?? throw new InvalidArgumentException("Unknown showcase component [{$slug}].");

        return CatalogComponent::fromArray($slug, $component, self::viewingVersion());
    }

    /**
     * Every component the installed plugin has, whichever version is
     * being viewed — used to register routes once at boot.
     *
     * @return list<CatalogComponent>
     */
    public static function installedComponents(): array
    {
        return self::components(self::installedVersion());
    }

    public static function hasComponent(string $slug): bool
    {
        return collect(self::components())->contains(fn (CatalogComponent $component): bool => $component->slug === $slug);
    }

    /**
     * Components the registry documents that need a newer plugin.
     */
    public static function upcomingCount(): int
    {
        return count(config('showcase.components', [])) - count(self::installedComponents());
    }

    /**
     * @return list<CatalogComponent>
     */
    public static function componentsIn(string $group): array
    {
        return array_values(array_filter(
            self::components(),
            fn (CatalogComponent $component): bool => $component->group === $group,
        ));
    }

    /**
     * Components added in the version being viewed.
     *
     * @return list<CatalogComponent>
     */
    public static function newComponents(): array
    {
        return array_values(array_filter(self::components(), fn (CatalogComponent $component): bool => self::isNew($component)));
    }

    public static function isNew(CatalogComponent $component): bool
    {
        return $component->since !== self::firstVersion() && $component->since === self::viewingVersion();
    }

    public static function isUpdated(CatalogComponent $component): bool
    {
        return $component->updateIn(self::viewingVersion()) !== null;
    }

    /**
     * "New", "Updated" or null — the badge the docs show for a component.
     */
    public static function badgeFor(CatalogComponent $component): ?string
    {
        return match (true) {
            self::isNew($component) => 'New',
            self::isUpdated($component) => 'Updated',
            default => null,
        };
    }

    /**
     * The oldest documented version — nothing in it is "new".
     */
    public static function firstVersion(): string
    {
        return (string) (collect((array) config('showcase.versions', []))->last()['version'] ?? '1.0.0');
    }

    public static function tagCount(): int
    {
        return array_sum(array_map(fn (CatalogComponent $component): int => count($component->tags), self::components()));
    }

    /**
     * Components whose name, description or tags contain `$query`.
     *
     * @return list<CatalogComponent>
     */
    public static function search(string $query): array
    {
        $query = mb_strtolower(trim($query));

        if ($query === '') {
            return self::components();
        }

        return array_values(array_filter(self::components(), fn (CatalogComponent $component): bool => str_contains(mb_strtolower($component->name), $query)
            || str_contains(mb_strtolower($component->description), $query)
            || collect($component->tags)->contains(fn (string $tag): bool => str_contains($tag, $query))));
    }

    /**
     * @return list<Template>
     */
    public static function templates(): array
    {
        return collect(config('showcase.templates', []))
            ->map(fn (array $template, string $slug): Template => Template::fromArray($slug, $template))
            ->values()
            ->all();
    }

    public static function template(string $slug): Template
    {
        $template = config("showcase.templates.{$slug}") ?? throw new InvalidArgumentException("Unknown showcase template [{$slug}].");

        return Template::fromArray($slug, $template);
    }
}
