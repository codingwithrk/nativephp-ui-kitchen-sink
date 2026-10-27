<?php

namespace App\NativeComponents\Templates;

use App\Showcase\Catalog;
use App\Showcase\Template;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

/**
 * The Templates tab: complete screens, grouped by category.
 */
class TemplateBrowser extends NativeComponent
{
    public function render(): View
    {
        $templates = Catalog::templates();

        return view('native.templates.template-browser', [
            'templateCount' => count($templates),
            'categories' => collect($templates)
                ->groupBy(fn (Template $template): string => $template->category)
                ->map(fn ($group): array => $group->all())
                ->all(),
        ]);
    }
}
