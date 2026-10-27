@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Dropdown menu" description="A SwiftUI Menu on iOS and a Compose DropdownMenu on Android.">
        <ui:dropdown-menu>
            <ui:button variant="outline" icon-trailing="expand_more">Open menu</ui:button>

            <ui:dropdown-menu-label>My account</ui:dropdown-menu-label>
            <ui:dropdown-menu-item icon="person" @press="perform('Profile')">Profile</ui:dropdown-menu-item>
            <ui:dropdown-menu-item icon="credit_card" @press="perform('Billing')">Billing</ui:dropdown-menu-item>
            <ui:dropdown-menu-sub label="Share">
                <ui:dropdown-menu-item icon="link" @press="perform('Copy link')">Copy link</ui:dropdown-menu-item>
                <ui:dropdown-menu-item icon="mail" @press="perform('Email')">Email</ui:dropdown-menu-item>
            </ui:dropdown-menu-sub>
            <ui:dropdown-menu-separator />
            <ui:dropdown-menu-item icon="logout" destructive @press="perform('Log out')">Log out</ui:dropdown-menu-item>
        </ui:dropdown-menu>
    </ui:example>

    <ui:example title="Dynamic items" description="Items read from a PHP array, added after any item tags.">
        <ui:dropdown-menu :items="[
            ['label' => 'Rename', 'icon' => 'edit', 'press' => 'perform(\'Rename\')'],
            ['label' => 'Duplicate', 'icon' => 'content_copy', 'press' => 'perform(\'Duplicate\')'],
            ['divider' => true],
            ['label' => 'Delete', 'icon' => 'delete', 'press' => 'perform(\'Delete\')', 'destructive' => true],
        ]">
            <ui:button variant="ghost" size="icon" icon="more_horiz" a11y-label="File actions" />
        </ui:dropdown-menu>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
