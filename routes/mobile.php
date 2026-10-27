<?php

use App\NativeComponents\About;
use App\NativeComponents\Components\ComponentBrowser;
use App\NativeComponents\Components\ComponentGroupScreen;
use App\NativeComponents\Components\SidebarDemo;
use App\NativeComponents\Home;
use App\NativeComponents\Templates\TemplateBrowser;
use App\NativeComponents\Themes;
use App\NativeComponents\UpdateRequired;
use App\NativeLayouts\ShowcaseTabsLayout;
use App\Showcase\Catalog;
use Illuminate\Support\Facades\Route;

Route::nativeGroup(ShowcaseTabsLayout::class, function () {
    Route::native('/', Home::class);
    Route::native('/components', ComponentBrowser::class);
    Route::native('/themes', Themes::class);
    Route::native('/templates', TemplateBrowser::class);
    Route::native('/about', About::class);
});

Route::native('/components/groups/{group}', ComponentGroupScreen::class);
Route::native('/update', UpdateRequired::class);

foreach (Catalog::installedComponents() as $component) {
    Route::native($component->url(), $component->screen());
}

if (Catalog::supports('1.1.0')) {
    Route::native('/components/sidebar/demo', SidebarDemo::class);
}

foreach (Catalog::templates() as $template) {
    Route::native($template->url(), $template->screen);
}
