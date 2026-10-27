<?php

namespace App\NativeComponents\Components;

use App\Showcase\Catalog;
use App\Showcase\CatalogComponent;
use App\Showcase\ComponentGroup;
use App\Showcase\Concerns\PicksDocsVersion;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * The Components tab: a grid of groups, or search results while the
 * viewer is typing, for the docs version being viewed.
 */
class ComponentBrowser extends NativeComponent
{
    use PicksDocsVersion;

    public string $search = '';

    public function clearSearch(): void
    {
        $this->search = '';
    }

    public function render(): View
    {
        $groups = Catalog::groups();

        return view('native.components.component-browser', [
            'isSearching' => filled(trim($this->search)),
            'results' => Catalog::search($this->search),
            'groupRows' => array_chunk($groups, 2),
            'groupCounts' => collect($groups)
                ->mapWithKeys(fn (ComponentGroup $group): array => [$group->slug => count(Catalog::componentsIn($group->slug))])
                ->all(),
            'groupColors' => collect($groups)
                ->mapWithKeys(fn (ComponentGroup $group): array => [$group->slug => $group->color])
                ->all(),
            'groupBadges' => collect(Catalog::components())
                ->filter(fn (CatalogComponent $component): bool => Catalog::badgeFor($component) !== null)
                ->groupBy('group')
                ->map(fn ($components): string => $components->contains(fn (CatalogComponent $component): bool => Catalog::isNew($component)) ? 'New' : 'Updated')
                ->all(),
            'badges' => collect(Catalog::components())
                ->mapWithKeys(fn (CatalogComponent $component): array => [$component->slug => Catalog::badgeFor($component)])
                ->all(),
            'componentCount' => count(Catalog::components()),
            'tagCount' => Catalog::tagCount(),
            ...$this->versionPickerData(),
        ]);
    }
}
