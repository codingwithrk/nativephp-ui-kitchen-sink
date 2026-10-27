@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Keys">
        <native:row class="gap-1">
            <ui:kbd>⌘</ui:kbd>
            <ui:kbd>⇧</ui:kbd>
            <ui:kbd>K</ui:kbd>
        </native:row>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
