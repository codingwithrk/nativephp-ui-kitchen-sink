<?php

namespace App\NativeComponents;

use App\Showcase\BannerAds;
use App\Showcase\Catalog;
use App\Showcase\Concerns\ShowsToasts;
use App\Showcase\PlatformIcon;
use Codingwithrk\PackageInfo\Facades\PackageInfo;
use Composer\InstalledVersions;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Facades\Browser;

/**
 * The About tab: what the app is, its version and build, links to the docs,
 * marketplace and source, the libraries it's built on and their licenses,
 * and how ads work.
 */
class About extends NativeComponent
{
    use ShowsToasts;

    public string $appName = '';

    public string $appVersion = '';

    public string $buildNumber = '';

    public string $packageName = '';

    /**
     * Read the app's real version and build from the device, falling back
     * to the NativePHP config off-device.
     */
    public function mount(): void
    {
        $info = class_exists(PackageInfo::class) ? PackageInfo::getInfo() : null;

        $this->appName = $info?->appName ?: (string) config('app.name');
        $this->appVersion = $info?->version ?: (string) config('nativephp.version');
        $this->buildNumber = $info?->buildNumber ?: (string) config('nativephp.version_code');
        $this->packageName = $info?->packageName ?: (string) config('nativephp.app_id');
    }

    public function openLink(string $link): void
    {
        $url = config("showcase.about.links.{$link}.url");

        if (is_string($url)) {
            Browser::inApp($url);
        }
    }

    public function openCredit(string $credit): void
    {
        $url = collect($this->credits())->firstWhere('key', $credit)['url'] ?? null;

        if (is_string($url) && filter_var($url, FILTER_VALIDATE_URL)) {
            Browser::inApp($url);
        }
    }

    /**
     * Credited packages with their license and homepage — Composer packages
     * read from vendor/composer/installed.json, the rest from config.
     *
     * @return list<array{key: string, name: string, version: ?string, license: string, url: ?string, note: ?string}>
     */
    public function credits(): array
    {
        $installed = self::installedPackages();

        return collect((array) config('showcase.about.credits', []))
            ->filter(fn (array $credit, string $key): bool => isset($credit['license']) || isset($installed[$key]))
            ->map(function (array $credit, string $key) use ($installed): array {
                $package = $installed[$key] ?? null;

                return [
                    'key' => $key,
                    'name' => $credit['name'] ?? $key,
                    'version' => $package !== null && InstalledVersions::isInstalled($key) ? ltrim((string) InstalledVersions::getPrettyVersion($key), 'vV') : null,
                    'license' => $credit['license'] ?? implode(', ', (array) ($package['license'] ?? ['Unknown'])),
                    'url' => $credit['url'] ?? $package['homepage'] ?? self::sourceUrl($package),
                    'note' => $credit['note'] ?? null,
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return array<string, array<string, mixed>> package name => installed.json entry
     */
    private static function installedPackages(): array
    {
        $path = base_path('vendor/composer/installed.json');

        if (! File::exists($path)) {
            return [];
        }

        $installed = json_decode((string) File::get($path), true);

        return collect($installed['packages'] ?? $installed ?? [])
            ->keyBy('name')
            ->all();
    }

    /**
     * @param  array<string, mixed>|null  $package
     */
    private static function sourceUrl(?array $package): ?string
    {
        $url = $package['source']['url'] ?? null;

        return is_string($url) ? preg_replace('/\.git$/', '', $url) : null;
    }

    public function render(): View
    {
        return view('native.about', [
            'description' => (string) config('showcase.about.description'),
            'links' => collect((array) config('showcase.about.links', []))
                ->map(fn (array $link): array => [...$link, 'icon' => PlatformIcon::fromArray($link['icon'])])
                ->all(),
            'credits' => $this->credits(),
            'pluginVersion' => Catalog::installedVersion(),
            'componentCount' => count(Catalog::installedComponents()),
            'adsEnabled' => BannerAds::isEnabled(),
            'adsInTestMode' => BannerAds::isTestMode(),
            'year' => now()->year,
        ]);
    }
}
