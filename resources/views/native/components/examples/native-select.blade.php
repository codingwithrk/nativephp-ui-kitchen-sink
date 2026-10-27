@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Native select" description="mobile-ui's own picker, so it behaves exactly like the platform control." align="stretch">
        <ui:native-select native:model="country" label="Country" :options="['India', 'United Kingdom', 'United States']" />
        <ui:muted>Selected: {{ $country }}</ui:muted>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
