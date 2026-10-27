@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Variants">
        <native:row class="w-full flex-wrap items-center justify-center gap-2">
            <ui:badge>Badge</ui:badge>
            <ui:badge variant="secondary">Secondary</ui:badge>
            <ui:badge variant="destructive">Destructive</ui:badge>
            <ui:badge variant="outline">Outline</ui:badge>
            <ui:badge variant="secondary" icon="check">Verified</ui:badge>
        </native:row>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
