@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Context menu" description="Long-press the row to open its actions." align="stretch">
        <ui:context-menu native:model="isMessageMenuOpen">
            <ui:item ref="message-row" variant="outline" icon="chat" title="Long-press me" description="Opens an action sheet" />

            <ui:context-menu-item icon="reply" @press="perform('Reply')">Reply</ui:context-menu-item>
            <ui:context-menu-item icon="content_copy" @press="perform('Copy text')">Copy text</ui:context-menu-item>
            <ui:context-menu-item icon="push_pin" @press="perform('Pin')">Pin</ui:context-menu-item>
            <ui:context-menu-separator />
            <ui:context-menu-item ref="delete" icon="delete" destructive @press="perform('Delete')">Delete</ui:context-menu-item>
        </ui:context-menu>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
