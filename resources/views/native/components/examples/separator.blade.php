@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Horizontal and vertical" align="stretch">
        <native:column class="w-full">
            <native:column class="gap-1">
                <ui:small>NativePHP UI</ui:small>
                <ui:muted>shadcn/ui for SuperNative screens.</ui:muted>
            </native:column>
            <ui:separator class="my-4" />
            <native:row class="h-5 items-center gap-4">
                <ui:muted>Blog</ui:muted>
                <ui:separator orientation="vertical" />
                <ui:muted>Docs</ui:muted>
                <ui:separator orientation="vertical" />
                <ui:muted>Source</ui:muted>
            </native:row>
        </native:column>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
