<?php

namespace App\Showcase\Concerns;

use App\Showcase\DocsVersion;

/**
 * State for the version switcher partial
 * (`native.components.partials.version-picker`): a pill that opens a sheet
 * of plugin versions.
 */
trait PicksDocsVersion
{
    public bool $isVersionSheetOpen = false;

    public string $viewedVersion = '';

    public function openVersionSheet(): void
    {
        $this->viewedVersion = DocsVersion::current();
        $this->isVersionSheetOpen = true;
    }

    public function updatedViewedVersion(): void
    {
        DocsVersion::view($this->viewedVersion);

        $this->viewedVersion = DocsVersion::current();
        $this->isVersionSheetOpen = false;
    }

    /**
     * @return array{viewingVersion: string, viewingStatus: string, versionOptions: list<array{version: string, status: string, released: ?string}>}
     */
    protected function versionPickerData(): array
    {
        $current = DocsVersion::current();

        return [
            'viewingVersion' => $current,
            'viewingStatus' => DocsVersion::details($current)['status'] ?? 'stable',
            'versionOptions' => DocsVersion::options(),
        ];
    }
}
