@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Toasts" description="Tap the buttons. At most three show at once, and each closes after its duration.">
        <native:column class="w-full gap-2">
            <ui:button ref="toast-success" icon="check" @press="save">Save changes</ui:button>
            <ui:button ref="toast-default" variant="outline" @press="notify">Create event</ui:button>
            <ui:button ref="toast-destructive" variant="destructive" @press="fail">Upload a large file</ui:button>
        </native:column>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
