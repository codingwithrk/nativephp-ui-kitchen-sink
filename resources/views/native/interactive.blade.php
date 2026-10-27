<native:top-bar title="Preferences" subtitle="Template" back />

<ui:page>
    {{-- Tabs --}}
    <native:column class="w-full gap-3">
        <ui:h3>Tabs</ui:h3>
        <ui:tabs native:model="tab">
            <ui:tabs-list>
                <ui:tabs-trigger ref="tab-overview" value="overview">Overview</ui:tabs-trigger>
                <ui:tabs-trigger ref="tab-analytics" value="analytics">Analytics</ui:tabs-trigger>
                <ui:tabs-trigger ref="tab-reports" value="reports">Reports</ui:tabs-trigger>
            </ui:tabs-list>
            <ui:tabs-content value="overview">
                <ui:card>
                    <ui:card-header>
                        <ui:card-title>Overview</ui:card-title>
                        <ui:card-description>Only the active panel is rendered.</ui:card-description>
                    </ui:card-header>
                    <ui:card-content>
                        <native:row class="w-full gap-3">
                            <ui:stat label="Users" value="2,350" change="+180" />
                            <ui:stat label="Sales" value="12,234" change="+19%" />
                        </native:row>
                    </ui:card-content>
                </ui:card>
            </ui:tabs-content>
            <ui:tabs-content value="analytics">
                <ui:card>
                    <ui:card-header>
                        <ui:card-title>Analytics</ui:card-title>
                        <ui:card-description>Traffic for the last 30 days.</ui:card-description>
                    </ui:card-header>
                    <ui:card-content>
                        <ui:small>Organic</ui:small>
                        <ui:progress :value="72" />
                        <ui:small>Referral</ui:small>
                        <ui:progress :value="38" />
                    </ui:card-content>
                </ui:card>
            </ui:tabs-content>
            <ui:tabs-content value="reports">
                <ui:empty icon="description" title="No reports yet" description="Generate your first report to see it here.">
                    <ui:button size="sm" icon="add">New report</ui:button>
                </ui:empty>
            </ui:tabs-content>
        </ui:tabs>
    </native:column>

    <ui:separator />

    {{-- Toggles --}}
    <native:column class="w-full gap-3">
        <ui:h3>Toggle &amp; Toggle group</ui:h3>
        <native:row class="gap-2 items-center">
            <ui:toggle ref="bold" native:model="isBold" icon="format_bold" a11y-label="Bold" />
            <ui:toggle ref="italic" native:model="isItalic" variant="outline" icon="format_italic" a11y-label="Italic" />
            <ui:muted>{{ collect(['bold' => $isBold, 'italic' => $isItalic])->filter()->keys()->implode(', ') ?: 'No formatting' }}</ui:muted>
        </native:row>

        <ui:small>Alignment (single)</ui:small>
        <ui:toggle-group type="single" native:model="alignment" variant="outline">
            <ui:toggle-group-item ref="align-left" value="left" icon="format_align_left" a11y-label="Align left" />
            <ui:toggle-group-item ref="align-center" value="center" icon="format_align_center" a11y-label="Align center" />
            <ui:toggle-group-item ref="align-right" value="right" icon="format_align_right" a11y-label="Align right" />
        </ui:toggle-group>

        <ui:small>Styles (multiple)</ui:small>
        <ui:toggle-group type="multiple" native:model="textStyles">
            <ui:toggle-group-item ref="style-underline" value="underline" icon="format_underlined" a11y-label="Underline" />
            <ui:toggle-group-item ref="style-strike" value="strikethrough" icon="strikethrough_s" a11y-label="Strikethrough" />
        </ui:toggle-group>
        <ui:muted>Align {{ $alignment }} · {{ count($textStyles) }} style(s) active</ui:muted>
    </native:column>

    <ui:separator />

    {{-- Controlled switch --}}
    <native:column class="w-full gap-3">
        <ui:h3>Controlled switch</ui:h3>
        <ui:item variant="outline" icon="wifi" title="Wi-Fi" :description="$isWifiEnabled ? 'Connected' : 'Off'">
            <ui:switch ref="wifi" :checked="$isWifiEnabled" @change="setWifi" />
        </ui:item>
    </native:column>

    <ui:separator />

    {{-- Accordion --}}
    <native:column class="w-full gap-3">
        <ui:h3>Accordion</ui:h3>
        <ui:accordion native:model="faq">
            <ui:accordion-item ref="faq-shipping" value="shipping" title="Is shipping free?">Yes. Shipping is free on all orders over $50.</ui:accordion-item>
            <ui:accordion-item ref="faq-returns" value="returns" title="Can I return my order?">Absolutely — within 30 days of delivery, no questions asked.</ui:accordion-item>
            <ui:accordion-item ref="faq-support" value="support" title="How do I contact support?">Email us any time; we reply within one business day.</ui:accordion-item>
        </ui:accordion>

        <ui:small>Multiple open</ui:small>
        <ui:accordion type="multiple" native:model="openSections">
            <ui:accordion-item ref="section-native" value="native" title="Is it really native?">Yes. Every tag compiles to EDGE elements rendered by SwiftUI and Jetpack Compose.</ui:accordion-item>
            <ui:accordion-item ref="section-theme" value="theme" title="Can I theme it?">Pick a base color, an accent and a radius in config/nativephp-ui.php.</ui:accordion-item>
        </ui:accordion>
    </native:column>

    @include('native.partials.banner-ad-space')
</ui:page>
