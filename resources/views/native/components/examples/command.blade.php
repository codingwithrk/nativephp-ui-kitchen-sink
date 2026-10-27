@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Command" description="A search field over grouped, filterable items." align="stretch">
        <ui:command ref="command" placeholder="Type a command or search…" @select="runCommand" :items="$commands" />
        @if (filled($lastCommand))
            <ui:muted>Last command: {{ $lastCommand }}</ui:muted>
        @endif
    </ui:example>

    <ui:example title="Command dialog" description="The same palette inside a large sheet.">
        <ui:button ref="open-palette" variant="outline" icon="search" @press="openPalette">Open command palette</ui:button>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>

<ui:sheet ref="palette" native:model="isPaletteOpen" detents="large">
    <ui:command placeholder="Type a command or search…" @select="runCommand" :items="$commands" />
</ui:sheet>
