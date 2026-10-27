@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Icon toggle">
        <ui:toggle ref="bold" native:model="isBold" icon="format_bold" a11y-label="Toggle bold" />
    </ui:example>

    <ui:example title="Outline with text">
        <native:row class="items-center gap-2">
            <ui:toggle ref="italic" variant="outline" native:model="isItalic" icon="format_italic">Italic</ui:toggle>
            <ui:toggle ref="underline" variant="outline" size="sm" native:model="isUnderlined" icon="format_underlined">Underline</ui:toggle>
        </native:row>
    </ui:example>

    <ui:example title="Controlled" description="Read the state from the pressed prop. The change handler is called with the new value.">
        <ui:toggle ref="star" :pressed="$isStarred" @change="setStarred" icon="star">{{ $isStarred ? 'Starred' : 'Star' }}</ui:toggle>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
