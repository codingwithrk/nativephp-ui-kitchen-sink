<?php

namespace App\NativeComponents;

use App\Showcase\BannerAds;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Overlay and list components: dialog, sheet and drawer (native bottom
 * sheets), item groups and the empty state.
 */
class Overlays extends NativeComponent
{
    public bool $isConfirmingDelete = false;

    public bool $isFiltersOpen = false;

    public bool $isShareDrawerOpen = false;

    /** @var list<array{id: int, name: string, status: string}> */
    private const array SampleProjects = [
        ['id' => 1, 'name' => 'Marketing site', 'status' => 'Live'],
        ['id' => 2, 'name' => 'Mobile app', 'status' => 'Building'],
        ['id' => 3, 'name' => 'Docs', 'status' => 'Live'],
        ['id' => 4, 'name' => 'Legacy dashboard', 'status' => 'Archived'],
    ];

    /** @var list<array{id: int, name: string, status: string}> */
    public array $projects = self::SampleProjects;

    public ?int $pendingProjectId = null;

    public string $sortBy = 'recent';

    public bool $showsArchived = false;

    public function confirmDelete(int $projectId): void
    {
        $this->pendingProjectId = $projectId;
        $this->isConfirmingDelete = true;
    }

    public function deleteProject(): void
    {
        $this->projects = array_values(array_filter(
            $this->projects,
            fn (array $project): bool => $project['id'] !== $this->pendingProjectId,
        ));

        $this->cancelDelete();
    }

    public function cancelDelete(): void
    {
        $this->pendingProjectId = null;
        $this->isConfirmingDelete = false;
    }

    public function restoreProjects(): void
    {
        $this->projects = self::SampleProjects;
    }

    public function openFilters(): void
    {
        $this->isFiltersOpen = true;
    }

    public function closeFilters(): void
    {
        $this->isFiltersOpen = false;
    }

    public function openShareDrawer(): void
    {
        $this->isShareDrawerOpen = true;
    }

    public function closeShareDrawer(): void
    {
        $this->isShareDrawerOpen = false;
    }

    /**
     * The projects to list, after applying the filters sheet.
     *
     * @return list<array{id: int, name: string, status: string}>
     */
    public function visibleProjects(): array
    {
        return collect($this->projects)
            ->when(! $this->showsArchived, fn ($projects) => $projects->where('status', '!=', 'Archived'))
            ->when($this->sortBy === 'name', fn ($projects) => $projects->sortBy('name'), fn ($projects) => $projects->sortByDesc('id'))
            ->values()
            ->all();
    }

    public function render(): View
    {
        return view('native.overlays', [
            'hasBannerSpace' => BannerAds::shouldShowOn($this, null),
            'visibleProjects' => $this->visibleProjects(),
            'pendingProject' => collect($this->projects)->firstWhere('id', $this->pendingProjectId),
        ]);
    }
}
