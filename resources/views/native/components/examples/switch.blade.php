@include('native.components.partials.top-bar')

<ui:page>
    @include('native.components.partials.header')

    <ui:example title="With label">
        <ui:switch ref="airplane" native:model="isAirplaneMode">Airplane mode</ui:switch>
    </ui:example>

    <ui:example title="Settings list" description="A switch without children renders just the track, which works well in the trailing slot of an item." align="stretch">
        <ui:item-group>
            <ui:item variant="outline" title="Marketing emails" description="Receive emails about new products.">
                <ui:switch ref="marketing" native:model="wantsMarketingEmails" />
            </ui:item>
            <ui:item variant="outline" title="Security emails" description="Receive emails about your account.">
                <ui:switch native:model="wantsSecurityEmails" disabled />
            </ui:item>
        </ui:item-group>
    </ui:example>

    <ui:example title="Controlled" description="The change handler receives the new value.">
        <ui:switch ref="wifi" :checked="$isWifiEnabled" @change="setWifi">Wi-Fi</ui:switch>
    </ui:example>

    <ui:example title="Small">
        <ui:switch ref="compact" size="sm" native:model="isCompactMode">Compact mode</ui:switch>
    </ui:example>

    @include('native.components.partials.footer')
</ui:page>
