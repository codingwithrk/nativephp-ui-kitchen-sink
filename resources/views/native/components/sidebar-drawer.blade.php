{{-- The side drawer for SidebarDemo. Presses resolve against that screen. --}}
<ui:sidebar>
    <ui:sidebar-header>
        <ui:item size="sm" icon="star" title="Acme Inc." description="Pro plan" />
    </ui:sidebar-header>

    <ui:sidebar-content>
        <ui:sidebar-group label="Platform">
            <ui:sidebar-menu>
                <ui:sidebar-menu-item ref="drawer-home" icon="home" :active="$section === 'home'" @press="openSection('home')">Home</ui:sidebar-menu-item>
                <ui:sidebar-menu-item ref="drawer-inbox" icon="mail" badge="12" :active="$section === 'inbox'" @press="openSection('inbox')">Inbox</ui:sidebar-menu-item>
                <ui:sidebar-menu-item ref="drawer-calendar" icon="event" :active="$section === 'calendar'" @press="openSection('calendar')">Calendar</ui:sidebar-menu-item>
            </ui:sidebar-menu>
        </ui:sidebar-group>
        <ui:sidebar-separator />
        <ui:sidebar-group label="Settings">
            <ui:sidebar-menu>
                <ui:sidebar-menu-item ref="drawer-profile" icon="person" :active="$section === 'profile'" @press="openSection('profile')">Profile</ui:sidebar-menu-item>
                <ui:sidebar-menu-item ref="drawer-billing" icon="credit_card" :active="$section === 'billing'" @press="openSection('billing')">Billing</ui:sidebar-menu-item>
            </ui:sidebar-menu>
        </ui:sidebar-group>
    </ui:sidebar-content>

    <ui:sidebar-footer>
        <ui:button ref="drawer-sign-out" variant="outline" icon="logout" @press="signOut">Sign out</ui:button>
    </ui:sidebar-footer>
</ui:sidebar>
