<?php

namespace App\Showcase;

use Illuminate\Support\Facades\File;

/**
 * The plugin version the viewer is browsing the docs for, like the site's
 * version switcher. Saved to a small JSON file; never newer than the
 * installed plugin.
 */
final class DocsVersion
{
    /** @var array<string, string> path|installed version => version, so a render doesn't re-read the file */
    private static array $cache = [];

    /**
     * Versions the viewer can pick: every documented version up to the
     * installed one, newest first.
     *
     * @return list<array{version: string, status: string, released: ?string}>
     */
    public static function options(): array
    {
        $installed = Catalog::installedVersion();

        return array_values(array_filter(
            (array) config('showcase.versions', []),
            fn (array $version): bool => version_compare($version['version'], $installed, '<='),
        ));
    }

    /**
     * @return array{version: string, status: string, released: ?string}|null
     */
    public static function details(string $version): ?array
    {
        return collect((array) config('showcase.versions', []))->firstWhere('version', $version);
    }

    public static function current(): string
    {
        $path = self::path();
        $key = self::cacheKey();

        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $saved = File::exists($path) ? json_decode((string) File::get($path), true)['version'] ?? null : null;

        return self::$cache[$key] = self::isOption($saved) ? $saved : Catalog::installedVersion();
    }

    public static function view(string $version): void
    {
        if (! self::isOption($version)) {
            return;
        }

        File::ensureDirectoryExists(dirname(self::path()));
        File::put(self::path(), json_encode(['version' => $version]));

        self::$cache = [self::cacheKey() => $version];
    }

    public static function forget(): void
    {
        File::delete(self::path());

        self::$cache = [];
    }

    public static function isLatest(): bool
    {
        return self::current() === Catalog::installedVersion();
    }

    private static function isOption(mixed $version): bool
    {
        return is_string($version) && collect(self::options())->contains('version', $version);
    }

    private static function cacheKey(): string
    {
        return self::path().'|'.Catalog::installedVersion();
    }

    private static function path(): string
    {
        return (string) config('showcase.theme.version_path', storage_path('app/showcase-version.json'));
    }
}
