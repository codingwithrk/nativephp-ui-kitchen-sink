<?php

namespace App\NativeLayouts;

use App\Icons\Android;
use App\Icons\Ios;
use Native\Mobile\Edge\Layouts\Builders\Tab;
use Native\Mobile\Edge\Layouts\Builders\TabBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

/**
 * The top-level sections. Each screen authors its own top bar;
 * pushed screens (component examples, templates) have no tab bar.
 */
class ShowcaseTabsLayout extends NativeLayout
{
    public function tabBar(NativeComponent $screen): ?TabBar
    {
        return TabBar::make()
            ->activeColor(theme('ui-primary'))
            ->add(Tab::link('Home', '/', ios: Ios::House, android: Android::Home))
            ->add(Tab::link('Components', '/components', ios: Ios::SquareGrid2x2, android: Android::Widgets))
            ->add(Tab::link('Themes', '/themes', ios: Ios::Paintpalette, android: Android::Palette))
            ->add(Tab::link('Templates', '/templates', ios: Ios::RectangleStack, android: Android::AutoAwesomeMosaic))
            ->add(Tab::link('About', '/about', ios: Ios::InfoCircle, android: Android::Info));
    }
}
