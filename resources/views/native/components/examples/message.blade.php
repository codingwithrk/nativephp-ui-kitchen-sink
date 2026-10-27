@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Chat screen" description="Type a message and tap send. User bubbles sit on the right." align="stretch" class="h-[420] p-0 gap-0 overflow-hidden">
        <ui:message-scroller>
            @foreach ($messages as $message)
                <ui:message native:key="m-{{ $message['id'] }}" :from="$message['role']" :fallback="$message['initials']">
                    <ui:bubble>{{ $message['text'] }}</ui:bubble>
                </ui:message>
            @endforeach
        </ui:message-scroller>
        <native:row class="w-full items-center gap-2 p-3 border-t border-theme-ui-border bg-theme-ui-background">
            <ui:input-group class="flex-1">
                <ui:input-group-input ref="draft" native:model="draft" placeholder="Message" @submit="send" />
            </ui:input-group>
            <ui:button ref="send" size="icon" icon="send" a11y-label="Send" @press="send" />
        </native:row>
    </ui:example>

    <ui:example title="Name, time and attachment" align="stretch">
        <ui:message from="assistant" name="Assistant" time="9:41" fallback="AI">
            <ui:bubble>Here's the report you asked for.</ui:bubble>
            <ui:attachment name="report.pdf" size="2.4 MB" @press="perform('Open report')" />
        </ui:message>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
