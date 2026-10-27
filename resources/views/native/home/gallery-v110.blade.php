{{-- Needs nativephp-ui 1.1.0: select, chart, message and input-otp. --}}
<ui:gallery-tile ref="gallery-select" title="Select" :badge="$galleryBadges['select'] ?? null" @navigate='/components/select'>
    <native:column class="w-[200]">
        <ui:select ref="fruit" native:model="fruit" :options="['apple' => 'Apple', 'banana' => 'Banana', 'grapes' => 'Grapes']" />
    </native:column>
</ui:gallery-tile>

<ui:gallery-tile ref="gallery-chart" title="Chart" :badge="$galleryBadges['chart'] ?? null" @navigate='/components/chart'>
    <native:column class="w-[220]">
        <ui:chart :height="90" :data="['Jan' => 186, 'Feb' => 305, 'Mar' => 237, 'Apr' => 73, 'May' => 209, 'Jun' => 214]" />
    </native:column>
</ui:gallery-tile>

<ui:gallery-tile ref="gallery-chat" title="Chat" :badge="$galleryBadges['message'] ?? null" @navigate='/components/message'>
    <native:column class="w-[240] gap-2">
        <ui:message from="assistant" fallback="AI">
            <ui:bubble>Shipped to TestFlight?</ui:bubble>
        </ui:message>
        <ui:message from="user" fallback="RK">
            <ui:bubble>Yes, build 42 is live.</ui:bubble>
        </ui:message>
    </native:column>
</ui:gallery-tile>

<ui:gallery-tile ref="gallery-input-otp" title="Input OTP" :badge="$galleryBadges['input-otp'] ?? null" @navigate='/components/input-otp'>
    <ui:input-otp ref="otp" native:model="code" length="4" />
</ui:gallery-tile>
