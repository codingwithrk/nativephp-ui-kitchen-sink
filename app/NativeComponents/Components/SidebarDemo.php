<?php

namespace App\NativeComponents\Components;

use App\Showcase\Concerns\ShowsToasts;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\UI\Builders\Drawer;
use Native\Mobile\UI\Concerns\InteractsWithDrawer;

/**
 * A full-screen demo app with a real native side drawer holding a
 * `<ui:sidebar>`. Open it with the ☰ button or a swipe from the left edge;
 * its items switch the demo's section.
 */
class SidebarDemo extends NativeComponent
{
    use InteractsWithDrawer;
    use ShowsToasts;

    /** @var array<string, array{title: string, description: string}> */
    public const array Sections = [
        'home' => ['title' => 'Home', 'description' => 'Your workspace at a glance.'],
        'inbox' => ['title' => 'Inbox', 'description' => '12 unread messages.'],
        'calendar' => ['title' => 'Calendar', 'description' => 'What is coming up this week.'],
        'profile' => ['title' => 'Profile', 'description' => 'How others see you.'],
        'billing' => ['title' => 'Billing', 'description' => 'Your plan and invoices.'],
    ];

    /** Full-screen with a drawer: a banner would sit over its content. */
    protected bool $hidesBannerAd = true;

    public string $section = 'home';

    public bool $wantsNotifications = true;

    public function openSection(string $section): void
    {
        if (array_key_exists($section, self::Sections)) {
            $this->section = $section;
        }
    }

    public function signOut(): void
    {
        $this->toast('Signed out', 'Not really — this is a demo.');
    }

    public function drawerOverride(): ?Drawer
    {
        return Drawer::make(view('native.components.sidebar-drawer', [
            'section' => $this->section,
        ]))->width(300);
    }

    public function render(): View
    {
        return view('native.components.sidebar-demo', [
            'current' => self::Sections[$this->section],
        ]);
    }
}
