@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="In a real drawer" description="Opens a demo app whose side drawer is this sidebar. Tap the menu button or swipe in from the left edge.">
        <ui:button ref="open-sidebar-demo" icon="menu" icon-trailing="arrow_forward" @navigate='/components/sidebar/demo'>Open the sidebar demo</ui:button>
    </ui:example>

    <ui:example title="Sidebar" description="The same sidebar shown inline. Return it from your layout's drawer(), or a screen's drawerOverride()." align="stretch" class="p-0">
        <ui:sidebar>
            <ui:sidebar-header>
                <ui:item size="sm" icon="star" title="Acme Inc." description="Pro plan" />
            </ui:sidebar-header>

            <ui:sidebar-content>
                <ui:sidebar-group label="Platform">
                    <ui:sidebar-menu>
                        <ui:sidebar-menu-item icon="home" active>Home</ui:sidebar-menu-item>
                        <ui:sidebar-menu-item icon="mail" badge="12">Inbox</ui:sidebar-menu-item>
                        <ui:sidebar-menu-item icon="event">Calendar</ui:sidebar-menu-item>
                    </ui:sidebar-menu>
                </ui:sidebar-group>
                <ui:sidebar-separator />
                <ui:sidebar-group label="Settings">
                    <ui:sidebar-menu>
                        <ui:sidebar-menu-item icon="person">Profile</ui:sidebar-menu-item>
                        <ui:sidebar-menu-item icon="credit_card">Billing</ui:sidebar-menu-item>
                    </ui:sidebar-menu>
                </ui:sidebar-group>
            </ui:sidebar-content>

            <ui:sidebar-footer>
                <ui:button variant="outline" icon="logout" @press="perform('Sign out')">Sign out</ui:button>
            </ui:sidebar-footer>
        </ui:sidebar>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
