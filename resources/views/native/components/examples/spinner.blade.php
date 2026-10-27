@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Sizes">
        <native:row class="items-center gap-6">
            <ui:spinner />
            <ui:spinner size="large" />
        </native:row>
    </ui:example>

    <ui:example title="Inline with text">
        <native:row class="items-center gap-2">
            <ui:spinner />
            <ui:muted>Syncing your library…</ui:muted>
        </native:row>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
