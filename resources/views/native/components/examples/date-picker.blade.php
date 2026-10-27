@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Date picker" description="The compact iOS style. Tap the date to expand the calendar." align="stretch">
        <ui:date-picker native:model="due" label="Due date" />
    </ui:example>

    <ui:example title="Date and time" align="stretch">
        <ui:date-picker native:model="startsAt" label="Starts" mode="datetime" min="2026-01-01" />
    </ui:example>

    <ui:example title="Calendar" align="stretch">
        <ui:calendar native:model="day" />
        <ui:muted>Selected: {{ $day }}</ui:muted>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
