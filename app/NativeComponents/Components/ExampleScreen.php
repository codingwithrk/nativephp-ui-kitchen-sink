<?php

namespace App\NativeComponents\Components;

use App\Showcase\BannerAds;
use App\Showcase\Catalog;
use App\Showcase\CatalogComponent;
use App\Showcase\Concerns\ShowsToasts;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * Base screen for one component's live examples. The component is found
 * from the class name (`ButtonGroupExample` → `button-group`), so a
 * subclass only holds the state its examples bind to.
 */
abstract class ExampleScreen extends NativeComponent
{
    use ShowsToasts;

    public static function catalogEntry(): CatalogComponent
    {
        return Catalog::component(CatalogComponent::slugForScreen(static::class));
    }

    /**
     * Shows a toast naming the action an example triggered, for menu
     * items and buttons that have nothing else to do in a showcase.
     */
    public function perform(string $action): void
    {
        $this->toast($action, 'This action ran on the PHP side.');
    }

    /**
     * Extra data for the example view.
     *
     * @return array<string, mixed>
     */
    protected function viewData(): array
    {
        return [];
    }

    public function render(): View
    {
        $component = static::catalogEntry();

        return view($component->view(), [
            'component' => $component,
            'group' => Catalog::group($component->group),
            'isNew' => Catalog::isNew($component),
            'hasBannerSpace' => BannerAds::shouldShowOn($this, null),
            'updateNote' => $component->updateIn(Catalog::viewingVersion()),
            'viewingVersion' => Catalog::viewingVersion(),
            'siblingBadges' => collect(Catalog::componentsIn($component->group))
                ->mapWithKeys(fn (CatalogComponent $sibling): array => [$sibling->slug => Catalog::badgeFor($sibling)])
                ->all(),
            'related' => array_values(array_filter(
                Catalog::componentsIn($component->group),
                fn (CatalogComponent $sibling): bool => $sibling->slug !== $component->slug,
            )),
            ...$this->viewData(),
        ]);
    }
}
