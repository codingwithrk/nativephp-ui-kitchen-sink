@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Slider" description="mobile-ui's native slider, colored from the shadcn palette." align="stretch">
        <ui:field label="Volume" :description="$volume.'%'">
            <ui:slider native:model="volume" min="0" max="100" step="5" />
        </ui:field>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
