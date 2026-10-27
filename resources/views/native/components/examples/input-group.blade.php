@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Addons" description="Icons, text or buttons on either side of the input." align="stretch">
        <ui:input-group>
            <ui:input-group-addon><native:icon name="search" :size="16" class="text-theme-ui-muted-foreground" /></ui:input-group-addon>
            <ui:input-group-input ref="query" native:model="query" placeholder="Search…" />
            <ui:input-group-addon>12 results</ui:input-group-addon>
        </ui:input-group>

        <ui:input-group>
            <ui:input-group-addon>https://</ui:input-group-addon>
            <ui:input-group-input ref="domain" native:model="domain" placeholder="example" keyboard="url" />
            <ui:input-group-addon>.com</ui:input-group-addon>
        </ui:input-group>
    </ui:example>

    <ui:example title="With a button" description="Type a message and tap send." align="stretch">
        <ui:input-group>
            <ui:input-group-input ref="draft" native:model="draft" placeholder="Message" @submit="send" />
            <ui:input-group-addon>
                <ui:button ref="send" size="icon-sm" icon="send" a11y-label="Send" @press="send" />
            </ui:input-group-addon>
        </ui:input-group>
    </ui:example>

    <ui:example title="Textarea" align="stretch">
        <ui:input-group>
            <ui:input-group-textarea ref="notes" native:model="notes" placeholder="Add a note…" />
        </ui:input-group>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
