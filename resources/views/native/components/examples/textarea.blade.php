@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Textarea" align="stretch">
        <ui:textarea ref="message" native:model="message" placeholder="Type your message here." />
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
