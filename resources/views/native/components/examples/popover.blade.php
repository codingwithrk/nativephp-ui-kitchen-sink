@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Popover" description="Tap the trigger. The popover opens as a medium-height bottom sheet.">
        <ui:popover native:model="isDimensionsOpen">
            <ui:popover-trigger>
                <ui:button ref="open-dimensions" variant="outline" icon="tune">Dimensions</ui:button>
            </ui:popover-trigger>
            <ui:popover-content>
                <ui:dialog-header>
                    <ui:dialog-title>Dimensions</ui:dialog-title>
                    <ui:dialog-description>Set the dimensions for the layer.</ui:dialog-description>
                </ui:dialog-header>
                <ui:field label="Width"><ui:input native:model="width" /></ui:field>
                <ui:field label="Height"><ui:input native:model="height" /></ui:field>
                <ui:popover-close>
                    <ui:button class="w-full">Done</ui:button>
                </ui:popover-close>
            </ui:popover-content>
        </ui:popover>
        <ui:muted>{{ $width }} × {{ $height }}</ui:muted>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
