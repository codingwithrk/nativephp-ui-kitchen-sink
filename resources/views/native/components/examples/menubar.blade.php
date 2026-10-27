@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Menubar" description="A row of native menus.">
        <ui:menubar>
            <ui:menubar-menu label="File">
                <ui:menubar-item icon="add" @press="perform('New file')">New file</ui:menubar-item>
                <ui:menubar-item icon="folder" @press="perform('Open')">Open…</ui:menubar-item>
                <ui:menubar-separator />
                <ui:menubar-sub label="Share">
                    <ui:menubar-item @press="perform('Share by email')">Email</ui:menubar-item>
                    <ui:menubar-item @press="perform('Copy link')">Copy link</ui:menubar-item>
                </ui:menubar-sub>
            </ui:menubar-menu>
            <ui:menubar-menu label="Edit">
                <ui:menubar-item @press="perform('Undo')">Undo</ui:menubar-item>
                <ui:menubar-item @press="perform('Redo')">Redo</ui:menubar-item>
            </ui:menubar-menu>
            <ui:menubar-menu label="View">
                <ui:menubar-item @press="perform('Zoom')">Zoom</ui:menubar-item>
            </ui:menubar-menu>
        </ui:menubar>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
