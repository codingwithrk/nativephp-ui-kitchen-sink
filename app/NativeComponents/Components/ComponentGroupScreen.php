<?php

namespace App\NativeComponents\Components;

use App\Showcase\BannerAds;
use App\Showcase\Catalog;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Every component in one group, pushed from the Components tab.
 */
class ComponentGroupScreen extends NativeComponent
{
    public string $groupSlug = '';

    public function mount(): void
    {
        $this->groupSlug = (string) $this->param('group');
    }

    public function render(): View
    {
        $group = Catalog::group($this->groupSlug);
        $components = Catalog::componentsIn($group->slug);

        return view('native.components.component-group-screen', [
            'group' => $group,
            'components' => $components,
            'badges' => collect($components)
                ->mapWithKeys(fn ($component): array => [$component->slug => Catalog::badgeFor($component)])
                ->all(),
            'viewingVersion' => Catalog::viewingVersion(),
            'hasBannerSpace' => BannerAds::shouldShowOn($this, null),
            'tagCount' => array_sum(array_map(fn ($component): int => count($component->tags), $components)),
        ]);
    }
}
