@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Navigation menu" description="A horizontally scrolling row of links. Tap one to make it active." align="stretch">
        <ui:navigation-menu>
            <ui:navigation-menu-item ref="nav-home" icon="home" :active="$section === 'home'" @press="setSection('home')">Home</ui:navigation-menu-item>
            <ui:navigation-menu-item ref="nav-projects" icon="dashboard" :active="$section === 'projects'" @press="setSection('projects')">Projects</ui:navigation-menu-item>
            <ui:navigation-menu-item ref="nav-team" icon="group" :active="$section === 'team'" @press="setSection('team')">Team</ui:navigation-menu-item>
            <ui:navigation-menu-item ref="nav-settings" icon="settings" :active="$section === 'settings'" @press="setSection('settings')">Settings</ui:navigation-menu-item>
        </ui:navigation-menu>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
