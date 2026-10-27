@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="Navigation list" align="stretch">
        <ui:item-group>
            <ui:item icon="person" title="Profile" description="Name, photo, bio" chevron />
            <ui:item icon="credit_card" title="Billing" description="Plans and invoices" chevron />
            <ui:item icon="shield" title="Security" description="Password and 2FA" chevron />
        </ui:item-group>
    </ui:example>

    <ui:example title="Variants and trailing content" description="Children render in the trailing slot: a switch, a badge, a button, anything." align="stretch">
        <ui:item-group>
            <ui:item variant="outline" title="Two-factor authentication" description="Add an extra layer of security.">
                <ui:switch ref="two-factor" native:model="hasTwoFactor" />
            </ui:item>
            <ui:item variant="muted" title="Basic plan" description="Up to 3 projects.">
                <ui:badge variant="outline">Current</ui:badge>
            </ui:item>
            <ui:item size="sm" variant="outline" icon="download" title="Export data">
                <ui:button size="sm" variant="secondary">Export</ui:button>
            </ui:item>
        </ui:item-group>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
