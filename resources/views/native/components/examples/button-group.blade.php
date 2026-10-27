@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Button group">
        <ui:button-group>
            <ui:button ref="archive" variant="outline" @press="perform('Archive')">Archive</ui:button>
            <ui:button ref="report" variant="outline" @press="perform('Report')">Report</ui:button>
            <ui:button variant="outline" size="icon" icon="more_horiz" a11y-label="More" />
        </ui:button-group>
    </ui:example>

    <ui:example title="Vertical">
        <ui:button-group orientation="vertical">
            <ui:button variant="outline" size="icon" icon="add" a11y-label="Zoom in" />
            <ui:button variant="outline" size="icon" icon="close" a11y-label="Reset" />
        </ui:button-group>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
