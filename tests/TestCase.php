<?php

namespace Tests;

use App\Showcase\BannerAds;
use App\Showcase\DocsVersion;
use App\Showcase\ThemeSettings;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Point the showcase's theme and docs-version stores at throwaway
     * files, so a choice saved on this machine never leaks into tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'showcase.theme.path' => storage_path('framework/testing/showcase-theme-'.getmypid().'.json'),
            'showcase.theme.version_path' => storage_path('framework/testing/showcase-version-'.getmypid().'.json'),
        ]);

        ThemeSettings::defaults()->apply()->forget();
        DocsVersion::forget();
        BannerAds::reset();
    }

    protected function tearDown(): void
    {
        (new ThemeSettings)->forget();
        DocsVersion::forget();

        parent::tearDown();
    }
}
