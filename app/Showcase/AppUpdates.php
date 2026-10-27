<?php

namespace App\Showcase;

use Codingwithrk\PackageInfo\Facades\PackageInfo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Facades\Network;
use Native\Mobile\Facades\System;
use Throwable;

/**
 * Checks the update API (config `showcase.updates`) for a newer release on
 * this platform, compared against the installed version reported by
 * codingwithrk/package-info.
 *
 * The response is cached for `cache_minutes`, so launching the app doesn't
 * hit the network every time. While the device is offline the API isn't
 * called at all, but a cached response still applies, so a forced update
 * can't be dodged with airplane mode. Failures — no URL, offline, bad
 * JSON — mean "no update", never an error.
 */
final class AppUpdates
{
    private const string ReleaseCacheKey = 'showcase.app_update.release';

    private const string SkippedCacheKey = 'showcase.app_update.skipped';

    /**
     * The available update, or null when the app is up to date.
     */
    public static function check(bool $fresh = false): ?AppUpdate
    {
        $url = config('showcase.updates.url');

        if (! is_string($url) || $url === '') {
            return null;
        }

        $platform = self::platform();
        $installed = self::installedVersion();

        if ($fresh) {
            Cache::forget(self::ReleaseCacheKey);
        }

        $release = Cache::get(self::ReleaseCacheKey);

        if (! is_array($release)) {
            // Offline: don't call the API, and don't cache, so the next
            // launch with a connection checks again.
            if (self::isOffline()) {
                return null;
            }

            $release = self::fetch($url, $platform, $installed);

            if ($release !== null) {
                Cache::put(self::ReleaseCacheKey, $release, now()->addMinutes((int) config('showcase.updates.cache_minutes', 360)));
            }
        }

        $entry = $release[$platform] ?? null;

        if (! is_array($entry)) {
            return null;
        }

        $latest = ltrim((string) ($entry['version'] ?? ''), 'vV');
        $storeUrl = (string) ($entry['store_url'] ?? '');

        if (preg_match('/^\d+(\.\d+)*$/', $latest) !== 1
            || ! str_starts_with($storeUrl, 'https://')
            || version_compare($latest, $installed, '<=')) {
            return null;
        }

        return new AppUpdate(
            platform: $platform,
            installedVersion: $installed,
            latestVersion: $latest,
            storeUrl: $storeUrl,
            isForced: filter_var($entry['force_update'] ?? false, FILTER_VALIDATE_BOOLEAN),
            message: filled($entry['message'] ?? null) ? (string) $entry['message'] : null,
        );
    }

    /**
     * An optional update the user hasn't skipped. Forced updates can't be
     * skipped, so they always come back.
     */
    public static function shouldPrompt(AppUpdate $update): bool
    {
        return $update->isForced || Cache::get(self::SkippedCacheKey) !== $update->latestVersion;
    }

    /**
     * Stop prompting for this version. A newer release prompts again.
     */
    public static function skip(AppUpdate $update): void
    {
        if (! $update->isForced) {
            Cache::forever(self::SkippedCacheKey, $update->latestVersion);
        }
    }

    /**
     * The installed version: the store build's real version on a device
     * (codingwithrk/package-info), the NativePHP config elsewhere.
     */
    public static function installedVersion(): string
    {
        $info = null;

        try {
            $info = PackageInfo::getInfo();
        } catch (Throwable) {
            // Not on a device, or the plugin isn't available.
        }

        return ltrim((string) ($info?->version ?: config('nativephp.version')), 'vV');
    }

    /**
     * Whether nativephp/mobile-network reports no connection. An unknown
     * status (off-device, plugin missing, or an error) counts as online, so
     * the check still runs and simply fails quietly if it can't connect.
     */
    public static function isOffline(): bool
    {
        try {
            $status = Network::status();
        } catch (Throwable) {
            return false;
        }

        return $status !== null && empty($status->error) && ($status->connected ?? true) === false;
    }

    public static function platform(): string
    {
        return System::isIos() ? 'ios' : 'android';
    }

    /**
     * @return array<string, mixed>|null
     */
    private static function fetch(string $url, string $platform, string $installed): ?array
    {
        try {
            $response = Http::acceptJson()
                ->timeout((int) config('showcase.updates.timeout', 4))
                ->get($url, ['platform' => $platform, 'version' => $installed]);

            $data = $response->successful() ? $response->json() : null;

            if (! is_array($data)) {
                return null;
            }

            // `?platform=` answers with just that platform's release; keep
            // the both-platforms shape internally either way.
            return isset($data['version']) ? [$platform => $data] : $data;
        } catch (Throwable) {
            return null;
        }
    }
}
