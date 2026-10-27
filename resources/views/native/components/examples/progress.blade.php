@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Progress" align="stretch">
        <native:row class="w-full justify-between">
            <ui:small>Uploading…</ui:small>
            <ui:muted>{{ $percent }}%</ui:muted>
        </native:row>
        <ui:progress :value="$percent" />
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
