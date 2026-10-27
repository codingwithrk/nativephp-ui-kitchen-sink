@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Single selection" description="Tapping the active item again clears the value.">
        <ui:toggle-group type="single" native:model="alignment" variant="outline">
            <ui:toggle-group-item ref="align-left" value="left" icon="format_align_left" a11y-label="Align left" />
            <ui:toggle-group-item ref="align-center" value="center" icon="format_align_center" a11y-label="Align center" />
            <ui:toggle-group-item ref="align-right" value="right" icon="format_align_right" a11y-label="Align right" />
        </ui:toggle-group>
    </ui:example>

    <ui:example title="Multiple selection" description="With type multiple the bound property is an array.">
        <ui:toggle-group type="multiple" native:model="styles">
            <ui:toggle-group-item ref="style-bold" value="bold" icon="format_bold" a11y-label="Bold" />
            <ui:toggle-group-item ref="style-italic" value="italic" icon="format_italic" a11y-label="Italic" />
            <ui:toggle-group-item ref="style-underline" value="underline" icon="format_underlined" a11y-label="Underline" />
        </ui:toggle-group>
    </ui:example>

    <ui:example title="With text">
        <ui:toggle-group type="single" native:model="range" variant="outline" size="sm">
            <ui:toggle-group-item ref="range-day" value="day">Day</ui:toggle-group-item>
            <ui:toggle-group-item ref="range-week" value="week">Week</ui:toggle-group-item>
            <ui:toggle-group-item ref="range-month" value="month">Month</ui:toggle-group-item>
        </ui:toggle-group>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
